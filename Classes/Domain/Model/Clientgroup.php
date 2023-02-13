<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */
class Clientgroup extends AbstractEntity
{
    /**
     * title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * clients.
     *
     * @var ObjectStorage<Client>
     *
     * @Cascade("remove")
     */
    protected $clients;

    /**
     * __construct.
     */
    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead.
     */
    public function initializeObject(): void
    {
        $this->clients = $this->clients ?: new ObjectStorage();
    }

    /**
     * Returns the title.
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Adds a client.
     */
    public function addClient(Client $client): void
    {
        $this->clients->attach($client);
    }

    /**
     * Removes a client.
     *
     * @param Client $clientToRemove The client to be removed
     */
    public function removeClient(Client $clientToRemove): void
    {
        $this->clients->detach($clientToRemove);
    }

    /**
     * Returns the clients.
     *
     * @return ObjectStorage<Client> $client
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Sets the clients.
     *
     * @param ObjectStorage<Client> $client
     */
    public function setClients(ObjectStorage $client): void
    {
        $this->clients = $client;
    }
}
