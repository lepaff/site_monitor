<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */
class Extension extends AbstractEntity
{
    /**
     * title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * version.
     *
     * @var string
     */
    protected $version = '';

    /**
     * versionInstalled.
     *
     * @var string
     */
    protected $versionInstalled = '';

    /**
     * extensionDoc.
     *
     * @var Extensiondoc
     */
    protected $extensionDoc = '';

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
     * Returns the version.
     *
     * @return string $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the version.
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns the versionInstalled.
     *
     * @return string $versionInstalled
     */
    public function getVersionInstalled()
    {
        return $this->versionInstalled;
    }

    /**
     * Sets the versionInstalled.
     */
    public function setVersionInstalled(string $versionInstalled): void
    {
        $this->versionInstalled = $versionInstalled;
    }

    /**
     * Returns the extensionDoc.
     *
     * @return Extensiondoc $extensionDoc
     */
    public function getExtensionDoc()
    {
        return $this->extensionDoc;
    }

    /**
     * Sets the extensionDoc.
     */
    public function setExtensionDoc(Extensiondoc $extensionDoc): void
    {
        $this->extensionDoc = $extensionDoc;
    }
}
