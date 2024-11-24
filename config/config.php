<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    'database' => [
        'central' => env('DB_CONNECTION', 'mysql'),
        'template_connection' => null,
        'prefix' => 'tenant_',
        'suffix' => '',
        'create_users' => true,
    ],

    'bootstrappers' => [
        'tenant' => [],
        'branch' => []
    ],

    'modules' => [
        'tenant' => 'module tenant manager',
        'client' => 'module client',
        'suppliers' => 'module suppliers',
    ],

    'events' => [
        'tenant' => [
            'creating' => [],
            'created' => [],
            'saving' => [],
            'saved' => [],
            'updating' => [],
            'updated' => [],
            'deleting' => [],
            'deleted' => [],
            'initializing' => [],
            'initialized' => [],
            'ending' => [],
            'ended' => []
        ],
        'branch' => [
            'created' => [],
            'updated' => [],
            'deleted' => [],
            'initializing' => [],
            'initialized' => [],
        ],
        'database' => [
            'creating' => [],
            'created' => [],
            'migrated' => [],
            'seed' => [],
            'rolled_back' => [],
            'deleting' => [],
            'deleted' => [],
        ]
    ]
];
