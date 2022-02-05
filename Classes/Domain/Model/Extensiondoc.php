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
 * Extensiondoc
 */
class Extensiondoc extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * repository
     *
     * @var string
     */
    protected $repository = '';

    /**
     * versions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extensionversion>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $versions = null;

    /**
     * isSysExt
     *
     * @var int
     */
    protected $isSysExt = '';

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
        $this->versions = $this->versions ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the repository
     *
     * @return string $repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the repository
     *
     * @param string $repository
     * @return void
     */
    public function setRepository(string $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns the isSysExt
     *
     * @return int $isSysExt
     */
    public function getIsSysExt()
    {
        return $this->isSysExt;
    }

    /**
     * Sets the isSysExt
     *
     * @param int $isSysExt
     * @return void
     */
    public function setIsSysExt(int $isSysExt)
    {
        $this->isSysExt = $isSysExt;
    }

    /**
     * Adds a version
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Extensionversion $version
     * @return void
     */
    public function addVersion(\LEPAFF\SiteMonitor\Domain\Model\Extensionversion $version)
    {
        $this->versions->attach($version);
    }

    /**
     * Removes a version
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Extensionversion $versionToRemove The versions to be removed
     * @return void
     */
    public function removeSite(\LEPAFF\SiteMonitor\Domain\Model\Extensionversion $versionToRemove)
    {
        $this->versions->detach($versionToRemove);
    }

    /**
     * Returns the versions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extensionversion> $versions
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * Sets the versions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extensionversion> $versions
     * @return void
     */
    public function setVersions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $versions)
    {
        $this->versions = $versions;
    }
}
