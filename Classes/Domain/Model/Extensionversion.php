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
class Extensionversion extends AbstractEntity
{
    /**
     * version.
     *
     * @var string
     */
    protected $version = '';

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
}
