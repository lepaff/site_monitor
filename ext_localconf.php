<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SiteMonitor',
        'Dashboardlist',
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'list, show, generate, search',
        ],
        // non-cacheable actions
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'show, generate, search',
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SiteMonitor',
        'Generateajax',
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'generateAjax',
        ],
        // non-cacheable actions
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'generateAjax',
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    dashboardlist {
                        iconIdentifier = site_monitor-plugin-dashboardlist
                        title = LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_site_monitor_dashboardlist.name
                        description = LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_site_monitor_dashboardlist.description
                        tt_content_defValues {
                            CType = list
                            list_type = sitemonitor_dashboardlist
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'site_monitor-plugin-dashboardlist',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:site_monitor/Resources/Public/Icons/user_plugin_dashboardlist.svg']
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers']['sitemonitor-siteimport'] =
        \LEPAFF\SiteMonitor\Command\SitesCommandController::class;
})();
