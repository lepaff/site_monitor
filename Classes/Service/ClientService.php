<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Service;

use LEPAFF\SiteMonitor\Domain\Model\Extension;
use LEPAFF\SiteMonitor\Domain\Model\Extensiondoc;
use LEPAFF\SiteMonitor\Domain\Model\Extensionversion;
use LEPAFF\SiteMonitor\Domain\Model\Site;
use LEPAFF\SiteMonitor\Domain\Repository\ClientRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensionRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository;
use LEPAFF\SiteMonitor\Domain\Repository\SiteRepository;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @internal only to be used within Extbase, not part of TYPO3 Core API
 */
class ClientService implements SingletonInterface
{
    /**
     * siteRepository.
     *
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * siteRepository.
     *
     * @var SiteRepository
     */
    protected $siteRepository;

    /**
     * extensionRepository.
     *
     * @var ExtensionRepository
     */
    protected $extensionRepository;

    /**
     * extensiondocRepository.
     *
     * @var ExtensiondocRepository
     */
    protected $extensiondocRepository;

    /**
     * extensionversionRepository.
     *
     * @var ExtensionversionRepository
     */
    protected $extensionversionRepository;

    public function injectClientRepository(ClientRepository $clientRepository): void
    {
        $this->clientRepository = $clientRepository;
    }

    public function injectSiteRepository(SiteRepository $siteRepository): void
    {
        $this->siteRepository = $siteRepository;
    }

    public function injectExtensionRepository(ExtensionRepository $extensionRepository): void
    {
        $this->extensionRepository = $extensionRepository;
    }

    public function injectExtensiondocRepository(ExtensiondocRepository $extensiondocRepository): void
    {
        $this->extensiondocRepository = $extensiondocRepository;
    }

    public function injectExtensionversionRepository(ExtensionversionRepository $extensionversionRepository): void
    {
        $this->extensionversionRepository = $extensionversionRepository;
    }

    public function getAllClients()
    {
        return $this->clientRepository->findNextToGenerate();
    }

    /**
     * execute generate.
     *
     * @param int $uid
     *
     * @return null|object|string|void
     */
    public function executeGenerate($uid)
    {
        microtime(true);
        $client = $this->clientRepository->findByUid($uid);

        if ('' === $client->getUrl()) {
            // no url set - throw error
            // @todo
            // $this->addFlashMessage(
            //     'Please check the plugin settings.',
            //     'No source URL found.',
            //     \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
            // );
            // $this->redirect('list');
        }

        if (1 === $client->getHtaccess()) {
            // @todo
            DebugUtility::debug($client);
            $url = $client->getUrl();

            // Your username.
            $username = $client->getHtUser();
            // Your password.
            $password = $client->getHtPass();
            // Initiate cURL.
            $ch = curl_init($url);
            // Specify the username and password using the CURLOPT_USERPWD option.
            // curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            // Tell cURL to return the output as a string instead
            // of dumping it to the browser.
            $headers = [
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode("{$username}:{$password}"),
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Execute the cURL request.
            $json = curl_exec($ch);
            // Check for errors.
            if (0 !== curl_errno($ch)) {
                // If an error occured, throw an Exception.
                throw new Exception(curl_error($ch));
            }

            // Print out the response.
            // echo $json;
            DebugUtility::debug($json, 'json');

            exit;
        }
        $url = $client->getUrl().'/?type='.$client->getTypeParam();
        $json = GeneralUtility::getUrl($url);

        if (! $json) {
            // no json - throw error
            // redirect to show action with jsonError parameter
            // @todo
            $this->redirect(
                'show',
                'Monitor',
                'SiteMonitor',
                [
                    'client' => $client,
                    'errors' => [
                        'json' => 1,
                    ],
                ]
            );
        // @todo
        } else {
            $response = json_decode($json, true);
        }

        if (0 === count($client->getSite())) {
            $newSite = GeneralUtility::makeInstance(Site::class);
        } else {
            $newSite = $client->getSite()[0];
            // nothing changed - so do nothing
            if ($newSite->getTstampUpdated() === $response['lockDate']) {
                return true;
            }
        }
        $typo3Context = '';

        if (isset($response['typo3Context'])) {
            foreach ($response['typo3Context'] as $key => $context) {
                if (true === $context) {
                    $typo3Context = $key;
                }
            }
        }
        $packageStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $composerPackages = $this->getComposerPackageArray($response['composerPackages']);
        $lockPackages = $this->getComposerLockPackageArray($response['lockPackages']);

        if (0 === count($client->getSite())) {
            foreach ($response['composerPackages'] as $package) {
                $newExtension = GeneralUtility::makeInstance(Extension::class);
                $newExtension->setTitle($package['package']);

                if (isset($composerPackages[$package['package']])) {
                    $newExtension->setVersion($composerPackages[$newExtension->getTitle()]['version']);
                }

                if (isset($lockPackages[$package['package']])) {
                    $newExtension->setVersionInstalled($lockPackages[$package['package']]['version']);
                }
                // find or create extensionDoc for extension
                $extDoc = $this->findOrCreateExtensionDoc($package['package']);

                if (null !== $extDoc) {
                    $newExtension->setExtensionDoc($extDoc);
                }
                $packageStorage->attach($newExtension);
            }
            $newSite->setInstalledExtension($packageStorage);
        } else {
            $installedExtensions = $newSite->getInstalledExtension();

            foreach ($installedExtensions as $ext) {
                // find or create extensionDoc for extension
                $extDoc = $this->findOrCreateExtensionDoc($ext->getTitle());

                if (null !== $extDoc) {
                    $ext->setExtensionDoc($extDoc);
                }

                if (isset($composerPackages[$ext->getTitle()])) {
                    $ext->setTitle($composerPackages[$ext->getTitle()]['package']);
                    $ext->setVersion($composerPackages[$ext->getTitle()]['version']);

                    if (isset($lockPackages[$ext->getTitle()])) {
                        $ext->setVersionInstalled($lockPackages[$ext->getTitle()]['version']);
                    }
                } else {
                    unset($composerPackages[$ext->getTitle()]);
                    $installedExtensions->detach($ext);
                    $newSite->setInstalledExtension($installedExtensions);
                }
                // if ($ext->getTitle() === 'lms3/lms3token') {
                //     DebugUtility::debug($composerPackages, 'composerPackages');
                //     DebugUtility::debug($composerPackages[$ext->getTitle()], '$composerPackages[$ext->getTitle()]');
                //     die();
                // }
            }
        }
        $newSite->setPid(1);
        $newSite->setTstamp(time());
        $newSite->setTstampUpdated($response['lockDate']);
        $newSite->setTitle($response['websiteTitle']);
        $newSite->setPhpVersion($response['phpVersion']);
        $newSite->setTypo3Version($response['typo3Version']);
        $newSite->setTypo3Context($typo3Context);

        if (false !== $response['patchAvailable']) {
            $newSite->setPatchAvailable($response['patchAvailable']);
        }

        if (0 === count($client->getSite())) {
            $this->siteRepository->add($newSite);
            $client->addSite($newSite);
        } else {
            $this->siteRepository->update($newSite);
        }

        $this->clientRepository->update($client);

        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        $tableName = 'tx_sitemonitor_domain_model_site';
        $persistedSite = $this->siteRepository->findPersistedObject($newSite->getUid());
        $slug = $this->buildSlug($persistedSite[0], $tableName);

        $newSite->setSlug($slug);
        $this->siteRepository->update($newSite);

        // DebugUtility::debug($this->versionTime, '$this->versionTime');
        // DebugUtility::debug(microtime(true) - $timeAtStart, 'Execution time renderJson');
        return true;
    }

    private function buildSlug($record, $tableName, $slugFieldName = 'slug')
    {
        //      Get field configuration
        $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$slugFieldName]['config'];
        $evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);

        //      Initialize Slug helper
        /** @var SlugHelper $slugHelper */
        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            $tableName,
            $slugFieldName,
            $fieldConfig
        );

        //      Generate slug
        $slug = $slugHelper->generate($record, $record['pid']);
        $state = RecordStateFactory::forName($tableName)
            ->fromArray($record, $record['pid'], $record['uid']);

        //      Build slug depending on eval configuration
        if (in_array('uniqueInSite', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
        } elseif (in_array('uniqueInPid', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        } elseif (in_array('unique', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInTable($slug, $state);
        }

        return $slug;
    }

    private function getComposerPackageArray($packages)
    {
        $out = [];

        foreach ($packages as $package) {
            $out[$package['package']] = $package;
        }

        return $out;
    }

    private function getComposerLockPackageArray($packages)
    {
        $out = [];

        foreach ($packages as $package) {
            $out[$package['version']['name']] = $package['version'];
        }

        return $out;
    }

    private function findOrCreateExtensionDoc($ext)
    {
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $json = GeneralUtility::makeInstance(RequestFactory::class)->request('https://packagist.org/packages/'.$ext.'.json')->getBody()->getContents();
        $extDoc = $this->extensiondocRepository->findByTitle($ext);

        if (count($extDoc) > 0) {
            if (false !== $json) {
                $json = json_decode($json, true);
                /** @todo */
                $versionStorage = $this->getVersionsForExtension($json, $persistenceManager);
                $extDoc[0]->setVersions($versionStorage);
            }

            return $extDoc[0];
        }

        if (false !== $json) {
            $json = json_decode($json, true);

            if (null === $json) {
                return;
            }
            $newExtensionDoc = GeneralUtility::makeInstance(Extensiondoc::class);
            $newExtensionDoc->setTitle($json['package']['name']);
            $newExtensionDoc->setDescription($json['package']['description']);
            $newExtensionDoc->setRepository($json['package']['repository']);
            /** @todo */
            $versionStorage = $this->getVersionsForExtension($json, $persistenceManager);
            $newExtensionDoc->setVersions($versionStorage);

            if ('typo3/cms' === mb_substr($json['package']['name'], 0, 9)) {
                $newExtensionDoc->setIsSysExt(1);
            } else {
                $newExtensionDoc->setIsSysExt(0);
            }

            return $newExtensionDoc;
        }
    }

    private function getVersionsForExtension($json, $persistenceManager)
    {
        $versionStorage = GeneralUtility::makeInstance(ObjectStorage::class);

        foreach ($json['package']['versions'] as $version) {
            $extVersion = $this->extensionversionRepository->findByVersion($version['version']);

            if (count($extVersion) > 0) {
                $versionStorage->attach($extVersion[0]);
            } else {
                $newExtensionversion = GeneralUtility::makeInstance(Extensionversion::class);
                $newExtensionversion->setVersion($version['version']);
                $this->extensionversionRepository->add($newExtensionversion);
                $persistenceManager->persistAll();
                $versionStorage->attach($newExtensionversion);
            }
        }

        return $versionStorage;
    }
}
