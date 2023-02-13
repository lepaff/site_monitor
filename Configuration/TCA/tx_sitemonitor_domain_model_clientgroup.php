<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_clientgroup',
        'label' => 'title',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,username,password,secret,url',
        'iconfile' => 'EXT:site_monitor/Resources/Public/Icons/tx_sitemonitor_domain_model_clientgroup.gif',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, title, clients'],
    ],
    'palettes' => [
        'auth_palette' => [
            'showitem' => 'username, password, --linebreak--, secret',
        ],
        'url_general_palette' => [
            'showitem' => 'url, type_param',
        ],
        'url_htaccess_palette' => [
            'showitem' => 'htaccess, --linebreak--, ht_user, ht_pass',
        ],
        'url_urls_palette' => [
            'showitem' => ' url_fe, url_be, --linebreak--, url_gitlab',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_sitemonitor_domain_model_clientgroup',
                'foreign_table_where' => 'AND {#tx_sitemonitor_domain_model_clientgroup}.{#pid}=###CURRENT_PID### AND {#tx_sitemonitor_domain_model_clientgroup}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_clientgroup.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => '',
            ],
        ],
        'clients' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_clientgroup.clients',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sitemonitor_domain_model_client',
                'MM' => 'tx_sitemonitor_clientgroup_client_mm',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
    ],
];
