<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Website monitor',
    'description' => 'Extension to monitor (TYPO3) websites',
    'category' => 'plugin',
    'author' => 'Michael Paffrath',
    'author_email' => 'michael.paffrath@gmail.com',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
