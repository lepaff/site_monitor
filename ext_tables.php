<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sitemonitor_domain_model_site', 'EXT:site_monitor/Resources/Private/Language/locallang_csh_tx_sitemonitor_domain_model_site.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sitemonitor_domain_model_site');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sitemonitor_domain_model_extension', 'EXT:site_monitor/Resources/Private/Language/locallang_csh_tx_sitemonitor_domain_model_extension.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sitemonitor_domain_model_extension');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sitemonitor_domain_model_extensiondoc', 'EXT:site_monitor/Resources/Private/Language/locallang_csh_tx_sitemonitor_domain_model_extensiondoc.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sitemonitor_domain_model_extensiondoc');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sitemonitor_domain_model_client', 'EXT:site_monitor/Resources/Private/Language/locallang_csh_tx_sitemonitor_domain_model_client.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sitemonitor_domain_model_client');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sitemonitor_domain_model_clientgroup', 'EXT:site_monitor/Resources/Private/Language/locallang_csh_tx_sitemonitor_domain_model_clientgroup.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sitemonitor_domain_model_clientgroup');
})();
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
