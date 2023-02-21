<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
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
class Client extends AbstractEntity
{
    /**
     * title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * username.
     *
     * @var string
     */
    protected $username = '';

    /**
     * password.
     *
     * @var string
     */
    protected $password = '';

    /**
     * secret.
     *
     * @var string
     */
    protected $secret = '';

    /**
     * typeParam.
     *
     * @var string
     */
    protected $typeParam = '';

    /**
     * url.
     *
     * @var string
     */
    protected $url = '';

    /**
     * htaccess.
     *
     * @var bool
     */
    protected $htaccess = false;

    /**
     * htUser.
     *
     * @var string
     */
    protected $htUser = '';

    /**
     * htPass.
     *
     * @var string
     */
    protected $htPass = '';

    /**
     * urlFe.
     *
     * @var string
     */
    protected $urlFe = '';

    /**
     * urlBe.
     *
     * @var string
     */
    protected $urlBe = '';

    /**
     * urlGitlab.
     *
     * @var string
     */
    protected $urlGitlab = '';

    /**
     * site.
     *
     * @var ObjectStorage<Site>
     *
     * @Cascade("remove")
     */
    protected $site;

    /**
     * owner.
     *
     * @var ObjectStorage<FrontendUser>
     *
     * @Cascade("remove")
     */
    protected $owner;

    /**
     * developer.
     *
     * @var ObjectStorage<FrontendUser>
     *
     * @Cascade("remove")
     */
    protected $developer;

    /**
     * slug.
     *
     * @var string
     */
    protected $slug = '';

    /** clientgroup. */
    protected ?Clientgroup $clientgroup = null;

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
        $this->site = $this->site ?: new ObjectStorage();
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
     * Returns the username.
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Returns the password.
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password.
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returns the secret.
     *
     * @return string $secret
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Sets the secret.
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * Returns the typeParam.
     *
     * @return string $typeParam
     */
    public function getTypeParam()
    {
        return $this->typeParam;
    }

    /**
     * Sets the typeParam.
     */
    public function setTypeParam(string $typeParam): void
    {
        $this->typeParam = $typeParam;
    }

    /**
     * Returns the url.
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url.
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Returns the htaccess.
     *
     * @return bool $htaccess
     */
    public function getHtaccess()
    {
        return $this->htaccess;
    }

    /**
     * Sets the htaccess.
     */
    public function setHtaccess(bool $htaccess): void
    {
        $this->htaccess = $htaccess;
    }

    /**
     * Returns the htUser.
     *
     * @return string $htUser
     */
    public function getHtUser()
    {
        return $this->htUser;
    }

    /**
     * Sets the htUser.
     */
    public function setHtUser(string $htUser): void
    {
        $this->htUser = $htUser;
    }

    /**
     * Returns the htPass.
     *
     * @return string $htPass
     */
    public function getHtPass()
    {
        return $this->htPass;
    }

    /**
     * Sets the htPass.
     */
    public function setHtPass(string $htPass): void
    {
        $this->htPass = $htPass;
    }

    /**
     * Returns the urlFe.
     *
     * @return string $urlFe
     */
    public function getUrlFe()
    {
        return $this->urlFe;
    }

    /**
     * Sets the urlFe.
     */
    public function setUrlFe(string $urlFe): void
    {
        $this->urlFe = $urlFe;
    }

    /**
     * Returns the urlBe.
     *
     * @return string $urlBe
     */
    public function getUrlBe()
    {
        return $this->urlBe;
    }

    /**
     * Sets the urlBe.
     */
    public function setUrlBe(string $urlBe): void
    {
        $this->urlBe = $urlBe;
    }

    /**
     * Returns the urlGitlab.
     *
     * @return string $urlGitlab
     */
    public function getUrlGitlab()
    {
        return $this->urlGitlab;
    }

    /**
     * Sets the urlGitlab.
     */
    public function setUrlGitlab(string $urlGitlab): void
    {
        $this->urlGitlab = $urlGitlab;
    }

    /**
     * Adds a Site.
     */
    public function addSite(Site $site): void
    {
        $this->site->attach($site);
    }

    /**
     * Removes a Site.
     *
     * @param Site $siteToRemove The Site to be removed
     */
    public function removeSite(Site $siteToRemove): void
    {
        $this->site->detach($siteToRemove);
    }

    /**
     * Returns the site.
     *
     * @return ObjectStorage<Site> $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Sets the site.
     *
     * @param ObjectStorage<Site> $site
     */
    public function setSite(ObjectStorage $site): void
    {
        $this->site = $site;
    }

    /**
     * Returns the owner.
     *
     * @return ObjectStorage<FrontendUser> $owmer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Returns the developer.
     *
     * @return ObjectStorage<FrontendUser> $owmer
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * Returns the clientgroup.
     */
    public function getClientgroup(): ?Clientgroup
    {
        return $this->clientgroup;
    }

    /**
     * Sets the clientgroup.
     */
    public function setClientgroup(?Clientgroup $clientgroup): void
    {
        $this->clientgroup = $clientgroup;
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
}
