<?php declare(strict_types=1);

namespace LEPAFF\SiteMonitor\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * This file is part of the "Website monitor" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 Michael Paffrath <michael.paffrath@gmail.com>, Antwerpes AG
 */

/**
 * The repository for Clients.
 */
class ClientRepository extends Repository
{
//    protected $defaultOrderings = [
//        'sorting' => QueryInterface::ORDER_ASCENDING,
//    ];

    public function initializeObject(): void
    {
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');

        // don't add the pid constraint
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param mixed $title
     *
     * @return array|QueryResultInterface
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
     * @param mixed $filters
     *
     * @return object
     */
    public function findFilteredClients($filters)
    {
        $query = $this->createQuery();

        $constraints = [];

        foreach ($filters as $filterName => $filterItem) {
            if ('clientName' === $filterName && '' !== $filterItem) {
                $constraints[] = $query->like('title', '%'.$filterItem.'%');
            }

            if ('extensions' === $filterName && '' !== $filterItem) {
                $constraints[] = $query->equals('site.installedExtension.extensionDoc.uid', $filterItem);
            }

            if ('clientgroup' === $filterName && '' !== $filterItem) {
                $constraints[] = $query->equals('site.clientgroup.uid', $filterItem);
            }

            if ('typo3Versions' === $filterName && '' !== $filterItem) {
                $constraints[] = $query->equals('site.typo3Version', $filterItem);
            }
        }
        $query->matching(
            $query->logicalOr(
                $constraints
            )
        );

        return $query->execute();
    }

    /**
     * @return array|QueryResultInterface
     */
    public function findNextToGenerate()
    {
        $query = $this->createQuery();
        $query->setOrderings([
            'site.tstamp' => QueryInterface::ORDER_DESCENDING,
        ]);

        return $query->execute();
    }

    public function findByDemand(?int $limit = null, ?int $offset = null, ?array $overwriteDemand = null)
    {
        $query = $this->createQuery();
        $constraints = [];

        if (array_key_exists('clientName', $overwriteDemand) && '' !== $overwriteDemand['clientName']) {
            $constraints[] = $query->like('title', '%'.$overwriteDemand['clientName'].'%');
        }

        if (array_key_exists('extensions', $overwriteDemand) && '' !== $overwriteDemand['extensions']) {
            $constraints[] = $query->equals('site.installedExtension.extensionDoc.uid', $overwriteDemand['extensions']);
        }

        if (array_key_exists('clientgroup', $overwriteDemand) && '' !== $overwriteDemand['clientgroup']) {
            $constraints[] = $query->equals('site.clientgroup.uid', $overwriteDemand['clientgroup']);
        }

        if (array_key_exists('typo3Versions', $overwriteDemand) && '' !== $overwriteDemand['typo3Versions']) {
            $constraints[] = $query->equals('site.typo3Version', $overwriteDemand['typo3Versions']);
        }

        if (count($constraints) > 0) {
            $query->matching(
                $query->logicalAnd(
                    $constraints
                )
            );
        }

        $queryObject['maxItems'] = $query->count();
        $query->setOffset($offset);
        $query->setLimit($limit);
        $queryObject['results'] = $query->execute();

        return $queryObject;
    }
}
