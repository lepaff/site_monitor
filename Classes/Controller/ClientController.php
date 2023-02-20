<?php

namespace LEPAFF\SiteMonitor\Controller;

use Psr\Http\Message\ResponseInterface;

class ClientController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
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
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction(): ResponseInterface
    {
        return $this->htmlResponse();
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
}