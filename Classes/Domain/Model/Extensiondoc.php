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
class Extensiondoc extends AbstractEntity
{
    /**
     * title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * repository.
     *
     * @var string
     */
    protected $repository = '';

    /**
     * versions.
     *
     * @var ObjectStorage<Extensionversion>
     *
     * @Cascade("remove")
     */
    protected $versions;

    /**
     * isSysExt.
     *
     * @var int
     */
    protected $isSysExt = '';

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
        $this->versions = $this->versions ?: new ObjectStorage();
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
     * Returns the description.
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the repository.
     *
     * @return string $repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the repository.
     */
    public function setRepository(string $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Returns the isSysExt.
     *
     * @return int $isSysExt
     */
    public function getIsSysExt()
    {
        return $this->isSysExt;
    }

    /**
     * Sets the isSysExt.
     */
    public function setIsSysExt(int $isSysExt): void
    {
        $this->isSysExt = $isSysExt;
    }

    /**
     * Adds a version.
     */
    public function addVersion(Extensionversion $version): void
    {
        $this->versions->attach($version);
    }

    /**
     * Removes a version.
     *
     * @param Extensionversion $versionToRemove The versions to be removed
     */
    public function removeSite(Extensionversion $versionToRemove): void
    {
        $this->versions->detach($versionToRemove);
    }

    /**
     * Returns the versions.
     *
     * @return ObjectStorage<Extensionversion> $versions
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * Sets the versions.
     *
     * @param ObjectStorage<Extensionversion> $versions
     */
    public function setVersions(ObjectStorage $versions): void
    {
        $this->versions = $versions;
    }
}
