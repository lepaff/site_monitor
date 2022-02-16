<?php

declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Controller;

use LEPAFF\SiteMonitor\Domain\Model\Site;
use LEPAFF\SiteMonitor\Domain\Model\Client;
use LEPAFF\SiteMonitor\Domain\Model\Extension;
use LEPAFF\SiteMonitor\Domain\Model\Extensiondoc;
use LEPAFF\SiteMonitor\Domain\Model\Extensionversion;
use LEPAFF\SiteMonitor\Service\ClientService;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use GeorgRinger\NumberedPagination\NumberedPagination;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */

/**
 * MonitorController
 */
class MonitorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $versionTime = 0;
    /**
     * persistence manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * clientgroupRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ClientgroupRepository
     */
    protected $clientgroupRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ClientgroupRepository $clientgroupRepository
     */
    public function injectClientgroupRepository(\LEPAFF\SiteMonitor\Domain\Repository\ClientgroupRepository $clientgroupRepository)
    {
        $this->clientgroupRepository = $clientgroupRepository;
    }

    /**
     * clientRepository
     *
     * @var \LEPAFF\SiteMonitor\Domain\Repository\ClientRepository
     */
    protected $clientRepository = null;

    /**
     * @param \LEPAFF\SiteMonitor\Domain\Repository\ClientRepository $clientRepository
     */
    public function injectClientRepository(\LEPAFF\SiteMonitor\Domain\Repository\ClientRepository $clientRepository)
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

    /**
     * action index
     *
     * @return string|object|null|void
     */
    public function indexAction()
    {
        if($this->settings['action'] && count(explode('->', $this->settings['action'])) > 1) {
            $action = explode('->', $this->settings['action']);
            $this->actionForward($action[1], $action[0], 'SiteMonitor', ['forwarded' => true]);
        } else {
            $this->actionForward('list', 'Monitor', 'SiteMonitor', ['forwarded' => true]);
        }

    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $request = $this->request;
        $clientgroups = $this->clientgroupRepository->findAll();
        $clients = $this->clientRepository->findAll();
        $extensions = $this->extensiondocRepository->findNonSysExts();
        $paginationObjects = $this->getPaginationObjects($this->settings['pagination'], $request, $clients);

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'clientgroups' => $clientgroups,
            'extensions' => $extensions,
            'showPagination' => ($paginationObjects['itemsPerPage'] >= count($clients)) ? false : true,
            'pagination' => [
                'paginator' => $paginationObjects['paginator'],
                'pagination' => $paginationObjects['pagination'],
            ]
        ]);
    }

    /**
     * action grouplist
     *
     * @return string|object|null|void
     */
    public function grouplistAction()
    {
        $request = $this->request;
        $clientgroups = $this->clientgroupRepository->findAll();
        $extensions = $this->extensiondocRepository->findNonSysExts();
        $paginationObjects = $this->getPaginationObjects($this->settings['pagination'], $request, $clientgroups);

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'clientgroups' => $clientgroups,
            'extensions' => $extensions,
            'showPagination' => ($paginationObjects['itemsPerPage'] >= count($clientgroups)) ? false : true,
            'pagination' => [
                'paginator' => $paginationObjects['paginator'],
                'pagination' => $paginationObjects['pagination'],
            ]
        ]);
    }

    /**
     * action search
     *
     * @return string|object|null|void
     */
    public function searchAction()
    {
        $request = $this->request;
        $extensions = $this->extensiondocRepository->findNonSysExts();
        $arguments = $request->getArguments();
        $searchDemand = $request->getArguments()['searchDemand'];
        if (isset($searchDemand['extensions']) && ($searchDemand['extensions'] === '' && $searchDemand['clientName'] === '')) {
            $this->redirect('list');
        }
        if (isset($searchDemand)) {
            $clients = $this->clientRepository->findFilteredClients($searchDemand);
        } else {
            $clients = $this->clientRepository->findAll();
        }
        $paginationObjects = $this->getPaginationObjects($this->settings['pagination'], $request, $clients);

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'extensions' => $extensions,
            'arguments' => $arguments,
            'showPagination' => ($paginationObjects['itemsPerPage'] >= count($clients)) ? false : true,
            'pagination' => [
                'paginator' => $paginationObjects['paginator'],
                'pagination' => $paginationObjects['pagination'],
            ]
        ]);
    }

    /**
     * action show
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @param array $errors
     * @return string|object|null|void
     */
    public function showAction(
        \LEPAFF\SiteMonitor\Domain\Model\Client $client,
        array $errors = []
    )
    {
        if (count($client->getSite()) === 0) {
            $site = GeneralUtility::makeInstance(Site::class);
            $this->view->assign('site', $site);
        } else {
            $this->view->assign('site', $client->getSite()[0]);
        }
        if (isset($errors['json']) && $errors['json'] === '1') {
            $this->view->assign('errors', $errors);
        }
        $this->view->assign('client', $client);
    }

    /**
     * action generate
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @return string|object|null|void
     */
    public function generateAction(\LEPAFF\SiteMonitor\Domain\Model\Client $client) {
        $clientService = GeneralUtility::makeInstance(ClientService::class);
        $generated = $clientService->executeGenerate($client->getUid());
        if ($generated === true) {
            $this->redirect(
                'show',
                'Monitor',
                'SiteMonitor',
                [
                    'client' => $client
                ]
            );
        }
    }

    public function generateAjaxAction() {
        $arguments = $this->request->getArguments();
        if (isset($arguments['client'])) {
            $client = $this->clientRepository->findByUid($arguments['client']);

            $clientService = GeneralUtility::makeInstance(ClientService::class);
            $generated = $clientService->executeGenerate($client->getUid());
            if ($generated === true) {
                $this->view->assign('client', $client);
            }
        } else {
            // @todo
            // error handling
            $this->view->assign('request', $this->request->getArguments());
        }
    }

    private function getPaginationObjects($settings, $request, $clients) {
        $paginationObjects = [];

        $paginationObjects['itemsPerPage'] = ((int)$settings['itemsPerPage'] !== 0) ? (int)$settings['itemsPerPage'] : 3;
        $paginationObjects['maximumLinks'] = ((int)$settings['maximumLinks'] !== 0) ? (int)$settings['maximumLinks'] : 15;
        $paginationObjects['currentPage'] = $request->hasArgument('currentPage') ? (int)$request->getArgument('currentPage') : 1;
        $paginationObjects['paginator'] = new QueryResultPaginator($clients, $paginationObjects['currentPage'], $paginationObjects['itemsPerPage']);
        $paginationObjects['pagination'] = new NumberedPagination($paginationObjects['paginator'], $paginationObjects['maximumLinks']);

        return $paginationObjects;
    }

    /**
     * action forwarding
     * @param string $action
     * @param string $controller
     * @param string $extension
     * @param array $arguments
     */
    protected function actionForward($action, $controller, $extension, $arguments) {
        if (class_exists('ForwardResponse')) {
            // >= TYPO3 11
            return (new ForwardResponse($action))
                ->withControllerName($controller)
                ->withExtensionName($extension)
                ->withArguments($arguments);
        } else {
            // TYPO3 10
            $this->forward(
                $action,
                $controller,
                $extension,
                $arguments
            );
        }
    }

    /**
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $newClient
     * @return string|object|null|void
     */
    public function createAction(\LEPAFF\SiteMonitor\Domain\Model\Client $newClient)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->clientRepository->add($newClient);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("client")
     * @return string|object|null|void
     */
    public function editAction(\LEPAFF\SiteMonitor\Domain\Model\Client $client)
    {
        $this->view->assign('client', $client);
    }

    /**
     * action update
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @return string|object|null|void
     */
    public function updateAction(\LEPAFF\SiteMonitor\Domain\Model\Client $client)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->clientRepository->update($client);
        $this->redirect('list');
    }

    /**
     * action deleteConfirmation
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @return string|object|null|void
     */
    public function deleteConfirmationAction(\LEPAFF\SiteMonitor\Domain\Model\Client $client)
    {
        $this->view->assign('client', $client);
    }

    /**
     * action delete
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @return string|object|null|void
     */
    public function deleteAction(\LEPAFF\SiteMonitor\Domain\Model\Client $client)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->clientRepository->remove($client);
        $this->redirect('list');
    }
}
