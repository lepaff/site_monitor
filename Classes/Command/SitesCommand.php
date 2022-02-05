<?php
namespace LEPAFF\SiteMonitor\Command;

use LEPAFF\SiteMonitor\Domain\Model\Extensionversion;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class SitesCommand extends Command
{
    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Does something!')
            ->setHelp(
                'Will process something. '
                . 'There is no possibility whatsoever due to missing configuration')
            ->setAliases([
                'sitemonitor:sites'
            ]);
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $extensionversionRepository = GeneralUtility::makeInstance(ExtensionversionRepository::class);
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $extensiondocRepository = $objectManager->get(ExtensiondocRepository::class);
        $extensionversionRepository = $objectManager->get(ExtensionversionRepository::class);
        $extensiondocs = $extensiondocRepository->findAll();
        // $extensionversions = $extensionversionRepository->findAll();
        foreach ($extensiondocs as $extensiondoc) {
            $json = GeneralUtility::getUrl('https://packagist.org/packages/'.$extensiondoc->getTitle().'.json');
            if($json !== false) {
                $json = json_decode($json, true);
                $versionStorage = $this->getVersionsForExtension($json, $persistenceManager, $extensionversionRepository);
                $extensiondoc->setVersions($versionStorage);
                $extensiondocRepository->update($extensiondoc);
            }
            $persistenceManager->persistAll();
        }
        // DebugUtility::debug($extensiondocs);
        // DebugUtility::debug($extensionversions);

        return true;
    }

    private function getVersionsForExtension($json, $persistenceManager, $extensionversionRepository) {
        $versionStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        foreach($json['package']['versions'] as $version) {
            $extVersion = $extensionversionRepository->findByVersion($version['version']);
            if (count($extVersion) > 0) {
                $versionStorage->attach($extVersion[0]);
            } else {
                $newExtensionversion = GeneralUtility::makeInstance(Extensionversion::class);
                $newExtensionversion->setVersion($version['version']);
                $extensionversionRepository->add($newExtensionversion);
                $persistenceManager->persistAll();
                $versionStorage->attach($newExtensionversion);
            }
        }

        return $versionStorage;
    }
}
