<?php

/**
 * Returns an array of database connections.
 *
 * @var array<string, mixed>
 */
return array(

    /**
     * Defines the default connection to be used
     * if the connection is not yet specified.
     *
     * @var string
     */
    'default' => getenv('APP_DEFAULT_DB'),

    /**
     * Configuration for the Torin package.
     *
     * @var array<string, string>
     */
    'torin' => array(

        /**
         * @var string
         */
        'driver' => 'mysql',

        /**
         * @var string
         */
        'host' => getenv('TORIN_HOSTNAME'),

        /**
         * @var string
         */
        'username' => getenv('TORIN_USERNAME'),

        /**
         * @var string
         */
        'password' => getenv('TORIN_PASSWORD'),

        /**
         * @var string
         */
        'database' => getenv('TORIN_DATABASE'),

        /**
         * @var integer
         */
        'port' => getenv('TORIN_PORT'),

        /**
         * @var string
         */
        'charset' => getenv('TORIN_CHARSET'),

    ),

    /**
     * Configuration for a SQLite connection.
     *
     * @link https://www.sqlite.org
     *
     * @var array<string, string>
     */
    'sqlite' => array(

        /**
         * @var string
         */
        'driver' => 'sqlite',

        /**
         * @var string
         */
        'database' => __DIR__ . '/../../' . getenv('SQLITE_DATABASE'),

    ),

);
