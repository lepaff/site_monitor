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
 * Client
 */
class Client extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * username
     *
     * @var string
     */
    protected $username = '';

    /**
     * password
     *
     * @var string
     */
    protected $password = '';

    /**
     * secret
     *
     * @var string
     */
    protected $secret = '';

    /**
     * typeParam
     *
     * @var string
     */
    protected $typeParam = '';

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * htaccess
     *
     * @var int
     */
    protected $htaccess = '';

    /**
     * htUser
     *
     * @var string
     */
    protected $htUser = '';

    /**
     * htPass
     *
     * @var string
     */
    protected $htPass = '';

    /**
     * urlFe
     *
     * @var string
     */
    protected $urlFe = '';

    /**
     * urlBe
     *
     * @var string
     */
    protected $urlBe = '';

    /**
     * urlGitlab
     *
     * @var string
     */
    protected $urlGitlab = '';

    /**
     * site
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Site>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $site = null;

    /**
     * owner
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $owner = null;

    /**
     * developer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $developer = null;

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
        $this->site = $this->site ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username
     *
     * @param string $username
     * @return void
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Returns the password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Returns the secret
     *
     * @return string $secret
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Sets the secret
     *
     * @param string $secret
     * @return void
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Returns the typeParam
     *
     * @return string $typeParam
     */
    public function getTypeParam()
    {
        return $this->typeParam;
    }

    /**
     * Sets the typeParam
     *
     * @param string $typeParam
     * @return void
     */
    public function setTypeParam(string $typeParam)
    {
        $this->typeParam = $typeParam;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Returns the htaccess
     *
     * @return int $htaccess
     */
    public function getHtaccess()
    {
        return $this->htaccess;
    }

    /**
     * Sets the htaccess
     *
     * @param int $htaccess
     * @return void
     */
    public function setHtaccess(int $htaccess)
    {
        $this->htaccess = $htaccess;
    }

    /**
     * Returns the htUser
     *
     * @return string $htUser
     */
    public function getHtUser()
    {
        return $this->htUser;
    }

    /**
     * Sets the htUser
     *
     * @param string $htUser
     * @return void
     */
    public function setHtUser(string $htUser)
    {
        $this->htUser = $htUser;
    }

    /**
     * Returns the htPass
     *
     * @return string $htPass
     */
    public function getHtPass()
    {
        return $this->htPass;
    }

    /**
     * Sets the htPass
     *
     * @param string $htPass
     * @return void
     */
    public function setHtPass(string $htPass)
    {
        $this->htPass = $htPass;
    }

    /**
     * Returns the urlFe
     *
     * @return string $urlFe
     */
    public function getUrlFe()
    {
        return $this->urlFe;
    }

    /**
     * Sets the urlFe
     *
     * @param string $urlFe
     * @return void
     */
    public function setUrlFe(string $urlFe)
    {
        $this->urlFe = $urlFe;
    }

    /**
     * Returns the urlBe
     *
     * @return string $urlBe
     */
    public function getUrlBe()
    {
        return $this->urlBe;
    }

    /**
     * Sets the urlBe
     *
     * @param string $urlBe
     * @return void
     */
    public function setUrlBe(string $urlBe)
    {
        $this->urlBe = $urlBe;
    }

    /**
     * Returns the urlGitlab
     *
     * @return string $urlGitlab
     */
    public function getUrlGitlab()
    {
        return $this->urlGitlab;
    }

    /**
     * Sets the urlGitlab
     *
     * @param string $urlGitlab
     * @return void
     */
    public function setUrlGitlab(string $urlGitlab)
    {
        $this->urlGitlab = $urlGitlab;
    }

    /**
     * Adds a Site
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Site $site
     * @return void
     */
    public function addSite(\LEPAFF\SiteMonitor\Domain\Model\Site $site)
    {
        $this->site->attach($site);
    }

    /**
     * Removes a Site
     *
     * @param \LEPAFF\SiteMonitor\Domain\Model\Site $siteToRemove The Site to be removed
     * @return void
     */
    public function removeSite(\LEPAFF\SiteMonitor\Domain\Model\Site $siteToRemove)
    {
        $this->site->detach($siteToRemove);
    }

    /**
     * Returns the site
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Site> $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Sets the site
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEPAFF\SiteMonitor\Domain\Model\Site> $site
     * @return void
     */
    public function setSite(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $site)
    {
        $this->site = $site;
    }

    /**
     * Returns the owner
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $owmer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Returns the developer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $owmer
     */
    public function getDeveloper()
    {
        return $this->developer;
    }
}
