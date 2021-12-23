<?php

use Bootstrap\Init\Helpers\Helper;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => Helper::env('DB_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => Helper::env('DB_HOST'),
            'port' => Helper::env('DB_PORT'),
            'database' => Helper::env('DB_DATABASE'),
            'username' => Helper::env('DB_USERNAME'),
            'password' => Helper::env('DB_PASSWORD'),
            'unix_socket' => Helper::env('DB_SOCKET'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => Helper::env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => Helper::env('DB_HOST'),
            'port' => Helper::env('DB_PORT'),
            'database' => Helper::env('DB_DATABASE'),
            'username' => Helper::env('DB_USERNAME'),
            'password' => Helper::env('DB_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'sslmode' => 'prefer',
        ]

    ],

];
