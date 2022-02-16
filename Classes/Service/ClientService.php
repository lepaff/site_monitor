<?php
declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Service;

use LEPAFF\SiteMonitor\Domain\Model\Site;
use LEPAFF\SiteMonitor\Domain\Model\Extension;
use LEPAFF\SiteMonitor\Domain\Model\Extensiondoc;
use LEPAFF\SiteMonitor\Domain\Model\Extensionversion;
use LEPAFF\SiteMonitor\Domain\Repository\ClientRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @internal only to be used within Extbase, not part of TYPO3 Core API.
 */
class ClientService implements SingletonInterface
{
    /**
     * siteRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ClientRepository
     */
    protected $clientRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ClientRepository $clientRepository
     */
    public function injectClientRepository(ClientRepository $clientRepository): void
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * siteRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\SiteRepository
     */
    protected $siteRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\SiteRepository $siteRepository
     */
    public function injectSiteRepository(\LEPAFF\SiteMonitor\Domain\Repository\SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    /**
     * extensionRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ExtensionRepository
     */
    protected $extensionRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ExtensionRepository $extensionRepository
     */
    public function injectExtensionRepository(\LEPAFF\SiteMonitor\Domain\Repository\ExtensionRepository $extensionRepository)
    {
        $this->extensionRepository = $extensionRepository;
    }

    /**
     * extensiondocRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository
     */
    protected $extensiondocRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository $extensiondocRepository
     */
    public function injectExtensiondocRepository(\LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository $extensiondocRepository)
    {
        $this->extensiondocRepository = $extensiondocRepository;
    }

    /**
     * extensionversionRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository
     */
    protected $extensionversionRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository $extensionversionRepository
     */
    public function injectExtensionversionRepository(\LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository $extensionversionRepository)
    {
        $this->extensionversionRepository = $extensionversionRepository;
    }

    public function getAllClients() {
        $clients = $this->clientRepository->findNextToGenerate();

        return $clients;
    }

    /**
     * execute generate
     *
     * @param int $uid
     * @return string|object|null|void
     */
    public function executeGenerate($uid) {
        $timeAtStart = microtime(true);
        $client = $this->clientRepository->findByUid($uid);
        if ($client->getUrl() === '') {
            // no url set - throw error
            // @todo
            // $this->addFlashMessage(
            //     'Please check the plugin settings.',
            //     'No source URL found.',
            //     \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
            // );
            // $this->redirect('list');
        }

        if ($client->getHtaccess() === 1) {
            // @todo
            DebugUtility::debug($client);
            $url = $client->getUrl();

            //Your username.
            $username = $client->getHtUser();
            //Your password.
            $password = $client->getHtPass();
            //Initiate cURL.
            $ch = curl_init($url);
            //Specify the username and password using the CURLOPT_USERPWD option.
            // curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            //Tell cURL to return the output as a string instead
            //of dumping it to the browser.
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode("$username:$password")
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //Execute the cURL request.
            $json = curl_exec($ch);
            //Check for errors.
            if(curl_errno($ch)){
                //If an error occured, throw an Exception.
                throw new Exception(curl_error($ch));
            }

            //Print out the response.
            // echo $json;
            DebugUtility::debug($json, 'json');

            die();

        } else {
            $url = $client->getUrl() . '/?type=' . $client->getTypeParam();
            $json = GeneralUtility::getUrl($url);
        }

        if (!$json) {
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
                        'json' => 1
                    ]
                ]
            );
            // @todo
        } else {
            $response = json_decode($json, true);
        }

        if (count($client->getSite()) === 0) {
            $newSite = GeneralUtility::makeInstance(Site::class);
        } else {
            $newSite = $client->getSite()[0];
        }
        $typo3Context = '';
        if (isset($response['typo3Context'])) {
            foreach($response['typo3Context'] as $key => $context) {
                if ($context === true) {
                    $typo3Context = $key;
                }
            }
        }
        $packageStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $composerPackages = $this->getComposerPackageArray($response['composerPackages']);
        $lockPackages = $this->getComposerLockPackageArray($response['lockPackages']);
        if (count($client->getSite()) === 0) {
            foreach($response['composerPackages'] as $cKey => $package) {
                $newExtension = GeneralUtility::makeInstance(Extension::class);
                $newExtension->setTitle($package['package']);
                if(isset($composerPackages[$package['package']])) {
                    $newExtension->setVersion($composerPackages[$newExtension->getTitle()]['version']);
                }
                if (isset($lockPackages[$package['package']])) {
                    $newExtension->setVersionInstalled($lockPackages[$package['package']]['version']);
                }
                // find or create extensionDoc for extension
                $extDoc = $this->findOrCreateExtensionDoc($package['package']);
                if ($extDoc !== null) {
                    $newExtension->setExtensionDoc($extDoc);
                }
                $packageStorage->attach($newExtension);
            }
            $newSite->setInstalledExtension($packageStorage);
        } else {
            $installedExtensions = $newSite->getInstalledExtension();
            foreach($installedExtensions as $ext) {
                // find or create extensionDoc for extension
                $extDoc = $this->findOrCreateExtensionDoc($ext->getTitle());
                if ($extDoc !== null) {
                    $ext->setExtensionDoc($extDoc);
                }
                if(isset($composerPackages[$ext->getTitle()])) {
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
        $newSite->setTitle($response['websiteTitle']);
        $newSite->setPhpVersion($response['phpVersion']);
        $newSite->setTypo3Version($response['typo3Version']);
        $newSite->setTypo3Context($typo3Context);
        if($response['patchAvailable'] !== false) {
            $newSite->setPatchAvailable($response['patchAvailable']);
        }

        if (count($client->getSite()) === 0) {
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

    private function buildSlug($record, $tableName, $slugFieldName = 'slug') {
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
        if (in_array('uniqueInSite', $evalInfo)) {
            $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
        } else if (in_array('uniqueInPid', $evalInfo)) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        } else if (in_array('unique', $evalInfo)) {
            $slug = $slugHelper->buildSlugForUniqueInTable($slug, $state);
        }

        return $slug;
    }

    private function getComposerPackageArray($packages) {
        $out = [];
        foreach($packages as $package) {
            $out[$package['package']] = $package;
        }

        return $out;
    }

    private function getComposerLockPackageArray($packages) {
        $out = [];
        foreach($packages as $package) {
            $out[$package['version']['name']] = $package['version'];
        }

        return $out;
    }

    private function findOrCreateExtensionDoc($ext) {
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $json = GeneralUtility::getUrl('https://packagist.org/packages/'.$ext.'.json');
        $extDoc = $this->extensiondocRepository->findByTitle($ext);

        if (count($extDoc) > 0) {
            if($json !== false) {
                $json = json_decode($json, true);
                // @todo
                $versionStorage = $this->getVersionsForExtension($json, $persistenceManager);
                $extDoc[0]->setVersions($versionStorage);
            }
            return $extDoc[0];
        } else {
            // e.g. https://packagist.org/packages/friendsoftypo3/extension-builder.json
            if($json !== false) {
                $json = json_decode($json, true);
                if ($json === null) {
                    return null;
                }
                $newExtensionDoc = GeneralUtility::makeInstance(Extensiondoc::class);
                $newExtensionDoc->setTitle($json['package']['name']);
                $newExtensionDoc->setDescription($json['package']['description']);
                $newExtensionDoc->setRepository($json['package']['repository']);

                // @todo
                $versionStorage = $this->getVersionsForExtension($json, $persistenceManager);
                $newExtensionDoc->setVersions($versionStorage);

                if(substr($json['package']['name'], 0, 9) === 'typo3/cms') {
                    $newExtensionDoc->setIsSysExt(1);
                } else {
                    $newExtensionDoc->setIsSysExt(0);
                }

                return $newExtensionDoc;
            }
        }
    }

    private function getVersionsForExtension($json, $persistenceManager) {
        $versionStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        foreach($json['package']['versions'] as $version) {
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
