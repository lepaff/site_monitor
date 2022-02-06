<?php

declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Model;


/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */

/**
 * Clientgroup
 */
class Clientgroup extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * clients
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Client>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $clients = null;

    /**
     * __construct
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
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->clients = $this->clients ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Adds a client
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $client
     * @return void
     */
    public function addClient(\LEPAFF\SiteMonitor\Domain\Model\Client $client)
    {
        $this->clients->attach($client);
    }

    /**
     * Removes a client
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Client $clientToRemove The client to be removed
     * @return void
     */
    public function removeClient(\LEPAFF\SiteMonitor\Domain\Model\Client $clientToRemove)
    {
        $this->clients->detach($clientToRemove);
    }

    /**
     * Returns the clients
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Client> $client
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Sets the clients
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Client> $client
     * @return void
     */
    public function setClients(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $client)
    {
        $this->clients = $client;
    }
}
