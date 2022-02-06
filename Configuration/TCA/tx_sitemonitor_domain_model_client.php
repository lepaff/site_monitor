<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client',
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
        'iconfile' => 'EXT:site_monitor/Resources/Public/Icons/tx_sitemonitor_domain_model_client.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, title, slug, --div--;URLs, --palette--;;url_general_palette, --palette--;;url_htaccess_palette, --palette--;;url_urls_palette, --div--;Authorization, --palette--;;auth_palette, --div--;Team, owner, developer'],
    ],
    'palettes' => [
        'auth_palette' => [
            'showitem' => 'username, password, --linebreak--, secret'
        ],
        'url_general_palette' => [
            'showitem' => 'url, type_param'
        ],
        'url_htaccess_palette' => [
            'showitem' => 'htaccess, --linebreak--, ht_user, ht_pass'
        ],
        'url_urls_palette' => [
            'showitem' => ' url_fe, url_be, --linebreak--, url_gitlab'
        ],
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
                'foreign_table' => 'tx_sitemonitor_domain_model_client',
                'foreign_table_where' => 'AND {#tx_sitemonitor_domain_model_client}.{#pid}=###CURRENT_PID### AND {#tx_sitemonitor_domain_model_client}.{#sys_language_uid} IN (-1,0)',
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
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'username' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.username',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'password' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.password',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'secret' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.secret',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'type_param' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.type_param',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'htaccess' => [
            'exclude' => true,
            'onChange' => 'reload',
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.htaccess',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'eval' => 'int',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => false
                    ]
                ],
            ],
        ],
        'ht_user' => [
            'exclude' => true,
            'displayCond' => 'FIELD:htaccess:REQ:true',
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.ht_user',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'ht_pass' => [
            'exclude' => true,
            'displayCond' => 'FIELD:htaccess:REQ:true',
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.ht_pass',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required',
                'default' => ''
            ],
        ],
        'url_fe' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.url_fe',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'url_be' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.url_be',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'url_gitlab' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.url_gitlab',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'site' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.site',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_sitemonitor_domain_model_site',
                'MM' => 'tx_sitemonitor_client_site_mm',
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
		    'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.slug',
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
			    'eval' => 'uniqueInSite',
			    'default' => ''
		    ]
	    ],
        'owner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.owner',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_users',
                // @todo improve: replace (1) with variable. See:
                // https://docs.typo3.org/m/typo3/reference-tca/10.4/en-us/ColumnsConfig/Type/selectTree.html#foreign-table-where
                'foreign_table_where' => 'AND fe_users.usergroup IN (1) ORDER BY last_name',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 10,
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
        'developer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:site_monitor/Resources/Private/Language/locallang_db.xlf:tx_sitemonitor_domain_model_client.developer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_users',
                // @todo improve: replace (2) with variable. See:
                // https://docs.typo3.org/m/typo3/reference-tca/10.4/en-us/ColumnsConfig/Type/selectTree.html#foreign-table-where
                'foreign_table_where' => 'AND fe_users.usergroup IN (2) ORDER BY last_name',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 30,
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
