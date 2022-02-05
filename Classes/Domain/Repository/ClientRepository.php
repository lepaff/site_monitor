<?php

declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */

/**
 * The repository for Clients
 */
class ClientRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByExtensionTitle($title)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('site.installedExtension.title', $title)
        );

        return $query->execute();
    }

    /**
     * @return object
     */
    public function findFilteredClients($filters)
    {
        $query = $this->createQuery();

        $constraints = [];
        foreach($filters as $filterName => $filterItem) {
            if ($filterName === 'clientName' && $filterItem !== '') {
                $constraints[] = $query->like('title', '%' . $filterItem . '%');
            }
            if ($filterName === 'extensions' && $filterItem !== '') {
                $constraints[] = $query->equals('site.installedExtension.extensionDoc.uid', $filterItem);
            }
        }
        $query->matching(
            $query->logicalOr(
                $constraints
            )
        );

        return $query->execute();
    }
}
