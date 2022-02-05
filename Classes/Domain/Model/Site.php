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
 * Site
 */
class Site extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * typo3Version
     *
     * @var string
     */
    protected $typo3Version = '';

    /**
     * typo3Context
     *
     * @var string
     */
    protected $typo3Context = '';

    /**
     * phpVersion
     *
     * @var string
     */
    protected $phpVersion = '';

    /**
     * patchAvailable
     *
     * @var string
     */
    protected $patchAvailable = '';

    /**
     * tstamp
     *
     * @var \DateTime
     */
    protected $tstamp;#

    /**
     * slug
     *
     * @var string
     */
    protected $slug = '';

    /**
     * installedExtension
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extension>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $installedExtension = null;

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
        $this->installedExtension = $this->installedExtension ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the typo3Version
     *
     * @return string $typo3Version
     */
    public function getTypo3Version()
    {
        return $this->typo3Version;
    }

    /**
     * Sets the typo3Version
     *
     * @param string $typo3Version
     * @return void
     */
    public function setTypo3Version(string $typo3Version)
    {
        $this->typo3Version = $typo3Version;
    }

    /**
     * Returns the typo3Context
     *
     * @return string $typo3Context
     */
    public function getTypo3Context()
    {
        return $this->typo3Context;
    }

    /**
     * Sets the typo3Context
     *
     * @param string $typo3Context
     * @return void
     */
    public function setTypo3Context(string $typo3Context)
    {
        $this->typo3Context = $typo3Context;
    }

    /**
     * Returns the phpVersion
     *
     * @return string $phpVersion
     */
    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    /**
     * Sets the phpVersion
     *
     * @param string $phpVersion
     * @return void
     */
    public function setPhpVersion(string $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * Returns the patchAvailable
     *
     * @return string $patchAvailable
     */
    public function getPatchAvailable()
    {
        return $this->patchAvailable;
    }

    /**
     * Sets the patchAvailable
     *
     * @param string $patchAvailable
     * @return void
     */
    public function setPatchAvailable(string $patchAvailable)
    {
        $this->patchAvailable = $patchAvailable;
    }

    /**
     * Returns the slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     *
     * @param string $slug
     * @return void
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Returns the tstamp
     *
     * @return int $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the tstamp
     *
     * @param int $tstamp
     * @return void
     */
    public function setTstamp(int $tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Adds a Extension
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Extension $installedExtension
     * @return void
     */
    public function addInstalledExtension(\LEPAFF\SiteMonitor\Domain\Model\Extension $installedExtension)
    {
        $this->installedExtension->attach($installedExtension);
    }

    /**
     * Removes a Extension
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Extension $installedExtensionToRemove The Extension to be removed
     * @return void
     */
    public function removeInstalledExtension(\LEPAFF\SiteMonitor\Domain\Model\Extension $installedExtensionToRemove)
    {
        $this->installedExtension->detach($installedExtensionToRemove);
    }

    /**
     * Returns the installedExtension
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extension> $installedExtension
     */
    public function getInstalledExtension()
    {
        return $this->installedExtension;
    }

    /**
     * Returns the installedExtension as array for JSON view
     *
     * @return array
     */
    public function getInstalledExtensionArray()
    {
        return $this->installedExtension->toArray();
    }

    /**
     * Sets the installedExtension
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Extension> $installedExtension
     * @return void
     */
    public function setInstalledExtension(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $installedExtension)
    {
        $this->installedExtension = $installedExtension;
    }
}
