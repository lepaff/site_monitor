<?php

namespace LEPAFF\SiteMonitor\Controller;

use LEPAFF\SiteMonitor\Domain\Model\Client;
use LEPAFF\SiteMonitor\Domain\Repository\ClientRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ClientController extends ActionController
{
    /**
     * clientRepository.
     *
     * @var ClientRepository
     */
    protected $clientRepository;

    public function injectClientRepository(ClientRepository $clientRepository): void
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * action new.
     *
     * @return null|object|string|void
     */
    public function newAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create.
     *
     * @return null|object|string|void
     */
    public function createAction(Client $newClient)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', AbstractMessage::WARNING);
        $this->clientRepository->add($newClient);
        $this->redirect('list');
    }
}
