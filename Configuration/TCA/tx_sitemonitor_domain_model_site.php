<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site',
        'label' => 'title',
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
        'searchFields' => 'title,typo3_version,php_version',
        'iconfile' => 'EXT:site_monitor/Resources/Public/Icons/tx_sitemonitor_domain_model_site.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'title, slug, typo3_version, typo3_context, php_version, patch_available, tstamp_updated, --div--;Extensions, installed_extension, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
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
                'foreign_table' => 'tx_sitemonitor_domain_model_site',
                'foreign_table_where' => 'AND {#tx_sitemonitor_domain_model_site}.{#pid}=###CURRENT_PID### AND {#tx_sitemonitor_domain_model_site}.{#sys_language_uid} IN (-1,0)',
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
                        'invertStateDisplay' => true
                    ]
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
                    'allowLanguageSynchronization' => true
                ]
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
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp_updated' => [
            'label' => 'tstamp_updated',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'typo3_version' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.typo3_version',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'typo3_context' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.typo3_context',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'php_version' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.php_version',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'patch_available' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.patch_available',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'installed_extension' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.installed_extension',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sitemonitor_domain_model_extension',
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
        'slug' => [
		    'exclude' => true,
		    'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_site.slug',
		    'config' => [
			    'type' => 'slug',
			    'size' => 50,
			    'generatorOptions' => [
				    'fields' =>  ['title'],
				    'fieldSeparator' => '-',
				    'replacements' => [
					    '/' => '-',
					    '®' => '',
				    ],
			    ],
			    'fallbackCharacter' => '-',
			    'eval' => 'uniqueInPid',
			    'default' => ''
		    ]
	    ],
    ],
];
