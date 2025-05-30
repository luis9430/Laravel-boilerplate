<?php

return [
    'plugin' => [
        'name' => 'WP Laravel Boilerplate',
        'version' => '1.0.0',
        'text_domain' => 'wp-laravel-boilerplate',
        'minimum_wp_version' => '5.8',
        'minimum_php_version' => '7.4',
    ],
    
    'database' => [
        'table_prefix' => 'wp_laravel_',
        'migrations_table' => 'migrations',
    ],
    
    'cache' => [
        'enabled' => true,
        'driver' => 'transient', // transient, file, database
        'prefix' => 'wp_laravel_',
        'expiration' => 3600,
    ],
    
    'api' => [
        'version' => 'v1',
        'namespace' => 'wp-laravel',
        'rate_limit' => [
            'enabled' => true,
            'attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],
    
    'queue' => [
        'driver' => 'database', // database, sync
        'table' => 'jobs',
        'failed_table' => 'failed_jobs',
        'retry_after' => 90,
    ],
    
    'logging' => [
        'enabled' => true,
        'channel' => 'error_log', // error_log, file, database
        'level' => 'debug', // debug, info, warning, error
        'max_files' => 30,
    ],
    
    'features' => [
        'api' => true,
        'admin_ui' => true,
        'custom_post_types' => true,
        'shortcodes' => true,
        'widgets' => true,
        'gutenberg_blocks' => false,
    ],
];