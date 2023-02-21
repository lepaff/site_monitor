<?php

defined('TYPO3') || exit;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SiteMonitor',
    'Dashboardlist',
    'Monitor dashboardlist'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SiteMonitor',
    'Client',
    'Client'
);

$materialPluginSignature = 'sitemonitor_dashboardlist';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$materialPluginSignature] = 'layout,select_key,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$materialPluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $materialPluginSignature,
    'FILE:EXT:site_monitor/Configuration/FlexForms/Dashboardlist.xml'
);
