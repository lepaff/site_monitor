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
 * Extension
 */
class Extension extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * version
     *
     * @var string
     */
    protected $version = '';

    /**
     * versionInstalled
     *
     * @var string
     */
    protected $versionInstalled = '';

    /**
     * extensionDoc
     *
     * @var \LEPAFF\SiteMonitor\Domain\Model\Extensiondoc
     */
    protected $extensionDoc = '';

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
     * Returns the version
     *
     * @return string $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the version
     *
     * @param string $version
     * @return void
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * Returns the versionInstalled
     *
     * @return string $versionInstalled
     */
    public function getVersionInstalled()
    {
        return $this->versionInstalled;
    }

    /**
     * Sets the versionInstalled
     *
     * @param string $versionInstalled
     * @return void
     */
    public function setVersionInstalled(string $versionInstalled)
    {
        $this->versionInstalled = $versionInstalled;
    }

    /**
     * Returns the extensionDoc
     *
     * @return \LEPAFF\SiteMonitor\Domain\Model\Extensiondoc $extensionDoc
     */
    public function getExtensionDoc()
    {
        return $this->extensionDoc;
    }

    /**
     * Sets the extensionDoc
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Extensiondoc $extensionDoc
     * @return void
     */
    public function setExtensionDoc(\LEPAFF\SiteMonitor\Domain\Model\Extensiondoc $extensionDoc)
    {
        $this->extensionDoc = $extensionDoc;
    }
}
