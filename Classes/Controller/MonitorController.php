<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Controller;

use LEPAFF\SiteMonitor\Domain\Model\Client;
use LEPAFF\SiteMonitor\Domain\Model\Extension;
use LEPAFF\SiteMonitor\Domain\Model\Site;
use LEPAFF\SiteMonitor\Domain\Repository\ClientgroupRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ClientRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensiondocRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensionRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ExtensionversionRepository;
use LEPAFF\SiteMonitor\Domain\Repository\SiteRepository;
use LEPAFF\SiteMonitor\Service\ClientService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */
class MonitorController extends ActionController
{
    protected $versionTime = 0;

    /** @var int */
    protected $currentPage = 0;

    /** @var null */
    protected $limit;

    /** @var int */
    protected $offset = 0;

    /**
     * persistence manager.
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * clientgroupRepository.
     *
     * @var ClientgroupRepository
     */
    protected $clientgroupRepository;

    /**
     * clientRepository.
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

    public function injectClientgroupRepository(ClientgroupRepository $clientgroupRepository): void
    {
        $this->clientgroupRepository = $clientgroupRepository;
    }

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

    /**
     * action index.
     *
     * @return null|object|string|void
     */
    public function indexAction(): ResponseInterface
    {
        if ($this->settings['action'] && count(explode('->', $this->settings['action'])) > 1) {
            $action = explode('->', $this->settings['action']);
            $this->actionForward($action[1], $action[0], 'SiteMonitor', ['forwarded' => true]);
        } else {
            $this->actionForward('list', 'Monitor', 'SiteMonitor', ['forwarded' => true]);
        }

        return $this->htmlResponse();
    }

    /**
     * action list.
     *
     * @return null|object|string|void
     */
    public function listAction(): ResponseInterface
    {
        $request = $this->request;
        $arguments = $request->getArguments();
        $overwriteDemand = array_key_exists('searchDemand', $arguments) ? $arguments['searchDemand'] : [];
        $clientgroups = $this->clientgroupRepository->findAll();
        $queryResult = $this->clientRepository->findByDemand($this->limit, $this->offset, $overwriteDemand);
        $extensions = $this->extensiondocRepository->findNonSysExts();
        $pagination = $this->getPaginationVariables($queryResult);

        $typo3Versions = [];

        foreach ($queryResult['results'] as $client) {
            foreach ($client->getSite() as $site) {
                $versionKey = $site->getTypo3Version();

                if (! array_key_exists($versionKey, $typo3Versions)) {
                    $typo3Versions[$versionKey] = $site->getTypo3Version();
                }
            }
        }

        $this->view->assignMultiple([
            'settings' => $this->settings,
            'overwriteDemand' => $overwriteDemand,
            'clientgroups' => $clientgroups,
            'extensions' => $extensions,
            'typo3Versions' => $typo3Versions,
            'pagination' => $pagination,
            'clients' => $queryResult['results'],
        ]);

        return $this->htmlResponse();
    }

    /**
     * action show.
     *
     * @return null|object|string|void
     */
    public function showAction(Client $client, array $errors = []): ResponseInterface {
        if (0 === count($client->getSite())) {
            $site = GeneralUtility::makeInstance(Site::class);
            $this->view->assign('site', $site);
        } else {
            $this->view->assign('site', $client->getSite()[0]);
        }

        if (isset($errors['json']) && '1' === $errors['json']) {
            $this->view->assign('errors', $errors);
        }
        $this->view->assign('client', $client);

        return $this->htmlResponse();
    }

    /**
     * action generate.
     *
     * @return null|object|string|void
     */
    public function generateAction(Client $client)
    {
        $clientService = GeneralUtility::makeInstance(ClientService::class);
        $generated = $clientService->executeGenerate($client->getUid());

        if (true === $generated) {
            $this->redirect(
                'show',
                'Monitor',
                'SiteMonitor',
                [
                    'client' => $client,
                ]
            );
        }
    }

    public function generateAjaxAction(): ResponseInterface
    {
        $arguments = $this->request->getArguments();

        if (isset($arguments['client'])) {
            $client = $this->clientRepository->findByUid($arguments['client']);

            $clientService = GeneralUtility::makeInstance(ClientService::class);
            $generated = $clientService->executeGenerate($client->getUid());

            if (true === $generated) {
                $this->view->assign('client', $client);
            }
        } else {
            // @todo
            // error handling
            $this->view->assign('request', $this->request->getArguments());
        }

        return $this->htmlResponse();
    }

    /**
     * action update.
     *
     * @return null|object|string|void
     */
    public function updateAction(Client $client)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
        $this->clientRepository->update($client);
        $this->redirect('list');
    }

    /**
     * action deleteConfirmation.
     *
     * @return null|object|string|void
     */
    public function deleteConfirmationAction(Client $client): ResponseInterface
    {
        $this->view->assign('client', $client);

        return $this->htmlResponse();
    }

    /**
     * action delete.
     *
     * @return null|object|string|void
     */
    public function deleteAction(Client $client)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
        $this->clientRepository->remove($client);
        $this->redirect('list');
    }

    /**
     * Setting the basic pagination variables.
     */
    protected function initializeAction(): void
    {
        $arguments = $this->request->getArguments();

        $this->limit = (int) $this->settings['pagination']['itemsPerPage'];

        if (array_key_exists('currentPage', $arguments) && $arguments['currentPage'] > 0) {
            $this->currentPage = $arguments['currentPage'];
            $this->offset = $this->limit * $this->currentPage;
        }
    }

    /**
     * action forwarding.
     *
     * @param string $action
     * @param string $controller
     * @param string $extension
     * @param array $arguments
     */
    protected function actionForward($action, $controller, $extension, $arguments)
    {
        if (class_exists('ForwardResponse')) {
            // >= TYPO3 11
            return (new ForwardResponse($action))
                ->withControllerName($controller)
                ->withExtensionName($extension)
                ->withArguments($arguments);
        }
        // TYPO3 10
        $this->forward(
            $action,
            $controller,
            $extension,
            $arguments
        );
    }

    /**
     * @param mixed $queryResult
     *
     * @return array
     */
    protected function getPaginationVariables($queryResult)
    {
        $maxPages = ceil($queryResult['maxItems'] / $this->limit);
        $paginationLimit = 2;

        if ($this->currentPage + $paginationLimit < $maxPages - 1) {
            $pagination['hasMorePages'] = true;
        }

        $i = $this->currentPage - 1 <= 0 ? 1 : $this->currentPage - 1;

        if ($i >= 2) {
            $pagination['hasLessPages'] = true;
        }

        while ($i <= $maxPages && $i <= $this->currentPage + $paginationLimit + 1) {
            $pagination['pages'][$i - 1] = $i;
            ++$i;
        }
        $pagination['currentPage'] = $this->currentPage;
        $pagination['maxPages'] = $maxPages - 1;

        return $pagination;
    }
}
