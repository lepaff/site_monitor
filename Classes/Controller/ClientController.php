<?php

namespace LEPAFF\SiteMonitor\Controller;

use LEPAFF\SiteMonitor\Domain\Model\Client;
use LEPAFF\SiteMonitor\Domain\Repository\ClientgroupRepository;
use LEPAFF\SiteMonitor\Domain\Repository\ClientRepository;
use LEPAFF\SiteMonitor\Utility\SlugUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class ClientController extends ActionController
{
    /**
     * clientRepository.
     *
     * @var ClientRepository
     */
    protected $clientRepository;

    /** @var ClientgroupRepository */
    protected $clientgroupRepository;

    /** @var PersistenceManager */
    protected $persistenceManager;

    public function injectClientRepository(ClientRepository $clientRepository): void
    {
        $this->clientRepository = $clientRepository;
    }

    public function injectClientgroupRepository(ClientgroupRepository $clientgroupRepository): void
    {
        $this->clientgroupRepository = $clientgroupRepository;
    }

    public function injectPersistenceManager(PersistenceManager $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * action new.
     *
     * @return null|object|string|void
     */
    public function newAction(): ResponseInterface
    {
        $this->view->assign('clientgroups', $this->clientgroupRepository->findAll());

        return $this->htmlResponse();
    }

    /**
     * action edit.
     *
     * @return null|object|string|void
     */
    public function updateAction(Client $client): ResponseInterface
    {
        if ($this->request->hasArgument('update')) {
            $this->clientRepository->update($client);
            $this->view->assign('message', 'update');
        }
        $this->view->assign('client', $client);
        $this->view->assign('clientgroups', $this->clientgroupRepository->findAll());

        return $this->htmlResponse();
    }

    /**
     * action create.
     *
     * @return null|object|string|void
     *
     * @Extbase\Validate(param="newClient", validator="LEPAFF\SiteMonitor\Domain\Validator\ClientValidator")
     */
    public function createAction(Client $newClient)
    {
        $this->clientRepository->add($newClient);
        $this->persistenceManager->persistAll();

        // Generate Slug
        $tableName = 'tx_sitemonitor_domain_model_client';
        $slugFieldName = 'slug';
        $slug = SlugUtility::generateUniqueSlug($newClient->getUid(), $tableName, $slugFieldName);
        $newClient->setSlug($slug);

        // Update Slug
        $this->clientRepository->update($newClient);
        $this->persistenceManager->persistAll();

        $this->redirect('list', 'Monitor', null, ['message' => 'new'], $this->settings['monitorPid']);
    }

    /**
     * action delete.
     *
     * @return null|object|string|void
     */
    public function deleteAction(Client $client)
    {
        $this->clientRepository->remove($client);
        $this->persistenceManager->persistAll();
        $this->redirect('list', 'Monitor', null, ['message' => 'delete'], $this->settings['monitorPid']);
    }
}
