<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Model;

use DateTime;
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
class Site extends AbstractEntity
{
    /**
     * title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * typo3Version.
     *
     * @var string
     */
    protected $typo3Version = '';

    /**
     * typo3Context.
     *
     * @var string
     */
    protected $typo3Context = '';

    /**
     * phpVersion.
     *
     * @var string
     */
    protected $phpVersion = '';

    /**
     * patchAvailable.
     *
     * @var string
     */
    protected $patchAvailable = '';

    /**
     * tstamp.
     *
     * @var DateTime
     */
    protected $tstamp;

    /**
     * tstampUpdated.
     *
     * @var DateTime
     */
    protected $tstampUpdated;

    /**
     * slug.
     *
     * @var string
     */
    protected $slug = '';

    /**
     * installedExtension.
     *
     * @var ObjectStorage<Extension>
     *
     * @Cascade("remove")
     */
    protected $installedExtension;

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
        $this->installedExtension = $this->installedExtension ?: new ObjectStorage();
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
     * Returns the typo3Version.
     *
     * @return string $typo3Version
     */
    public function getTypo3Version()
    {
        return $this->typo3Version;
    }

    /**
     * Sets the typo3Version.
     */
    public function setTypo3Version(string $typo3Version): void
    {
        $this->typo3Version = $typo3Version;
    }

    /**
     * Returns the typo3Context.
     *
     * @return string $typo3Context
     */
    public function getTypo3Context()
    {
        return $this->typo3Context;
    }

    /**
     * Sets the typo3Context.
     */
    public function setTypo3Context(string $typo3Context): void
    {
        $this->typo3Context = $typo3Context;
    }

    /**
     * Returns the phpVersion.
     *
     * @return string $phpVersion
     */
    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    /**
     * Sets the phpVersion.
     */
    public function setPhpVersion(string $phpVersion): void
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * Returns the patchAvailable.
     *
     * @return string $patchAvailable
     */
    public function getPatchAvailable()
    {
        return $this->patchAvailable;
    }

    /**
     * Sets the patchAvailable.
     */
    public function setPatchAvailable(string $patchAvailable): void
    {
        $this->patchAvailable = $patchAvailable;
    }

    /**
     * Returns the slug.
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the slug.
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Returns the tstamp.
     *
     * @return int $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp.
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Returns the tstampUpdated.
     *
     * @return int $tstampUpdated
     */
    public function getTstampUpdated()
    {
        return $this->tstampUpdated;
    }

    /**
     * Sets the tstampUpdated.
     */
    public function setTstampUpdated(int $tstampUpdated): void
    {
        $this->tstampUpdated = $tstampUpdated;
    }

    /**
     * Adds a Extension.
     */
    public function addInstalledExtension(Extension $installedExtension): void
    {
        $this->installedExtension->attach($installedExtension);
    }

    /**
     * Removes a Extension.
     *
     * @param Extension $installedExtensionToRemove The Extension to be removed
     */
    public function removeInstalledExtension(Extension $installedExtensionToRemove): void
    {
        $this->installedExtension->detach($installedExtensionToRemove);
    }

    /**
     * Returns the installedExtension.
     *
     * @return ObjectStorage<Extension> $installedExtension
     */
    public function getInstalledExtension()
    {
        return $this->installedExtension;
    }

    /**
     * Returns the installedExtension as array for JSON view.
     *
     * @return array
     */
    public function getInstalledExtensionArray()
    {
        return $this->installedExtension->toArray();
    }

    /**
     * Sets the installedExtension.
     *
     * @param ObjectStorage<Extension> $installedExtension
     */
    public function setInstalledExtension(ObjectStorage $installedExtension): void
    {
        $this->installedExtension = $installedExtension;
    }
}
