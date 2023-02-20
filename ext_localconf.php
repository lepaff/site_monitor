<?php

defined('TYPO3') || exit;

(static function (): void {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SiteMonitor',
        'Dashboardlist',
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'index, list, show, generate, update, delete, deleteConfirmation',
        ],
        // non-cacheable actions
        [
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'show, generate, list, new, create, update, delete, deleteConfirmation',
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SiteMonitor',
        'ClientCreate',
        [
            \LEPAFF\SiteMonitor\Controller\ClientController::class => 'new, create, edit',
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'list',
        ],
        // non-cacheable actions
        [
            \LEPAFF\SiteMonitor\Controller\ClientController::class => 'new, create, edit',
            \LEPAFF\SiteMonitor\Controller\MonitorController::class => 'list',
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
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
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
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
                     clientcreate {
                        iconIdentifier = site_monitor-plugin-dashboardlist
                        title = LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_site_monitor_clientcreate.name
                        description = LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_site_monitor_clientcreate.description
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

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers']['sitemonitor-siteimport']
        = \LEPAFF\SiteMonitor\Command\SitesCommandController::class;
})();
