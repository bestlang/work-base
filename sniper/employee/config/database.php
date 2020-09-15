<?php
return [
        'proxy' => [
            'driver' => 'mysql',
            'url' => env('PROXY_DATABASE_URL', ''),
            'host' => env('PROXY_DB_HOST', '39.99.224.136'),
            'port' => env('PROXY_DB_PORT', '3306'),
            'database' => env('PROXY_DB_DATABASE', 'sniper-tech'),
            'username' => env('PROXY_DB_USERNAME', 'develop'),
            'password' => env('PROXY_DB_PASSWORD', 'develop123'),
            'unix_socket' => env('PROXY_DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
];