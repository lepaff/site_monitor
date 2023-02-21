<?php

namespace LEPAFF\SiteMonitor\Utility;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SlugUtility
{
    /**
     * @param int $uid UID of record saved in DB
     * @param string $tableName Name of the table to lookup for uniques
     * @param string $slugFieldName Name of the slug field
     *
     * @return string Resolved unique slug
     *
     * @throws SiteNotFoundException
     */
    public static function generateUniqueSlug(int $uid, string $tableName, string $slugFieldName): string
    {
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
        $queryBuilder = $connection->createQueryBuilder();

        $record = $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where('uid=:uid')
            ->setParameter(':uid', $uid)
            ->execute()
            ->fetchAssociative();

        if (! $record) {
            return false;
        }
//      Get field configuration
        $fieldConfig = $GLOBALS['TCA'][$tableName]['columns'][$slugFieldName]['config'];
        $evalInfo = GeneralUtility::trimExplode(',', $fieldConfig['eval'], true);

//      Initialize Slug helper
        /** @var SlugHelper $slugHelper */
        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            $tableName,
            $slugFieldName,
            $fieldConfig
        );
//      Generate slug
        $slug = $slugHelper->generate($record, $record['pid']);
        $state = RecordStateFactory::forName($tableName)
            ->fromArray($record, $record['pid'], $record['uid']);

//      Build slug depending on eval configuration
        if (in_array('uniqueInSite', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
        } elseif (in_array('uniqueInPid', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        } elseif (in_array('unique', $evalInfo, true)) {
            $slug = $slugHelper->buildSlugForUniqueInTable($slug, $state);
        }

        return $slug;
    }
}
