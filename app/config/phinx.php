<?php

// Define the root directory ---
$root = __DIR__ . '/../../';
// -----------------------------

// Load variables from ".env" ---
$env = new Dotenv\Dotenv($root);

$env->load();
// ------------------------------

/**
 * Returns a configuration file specifically for Phinx.
 *
 * @link https://book.cakephp.org/phinx/0/en/index.html
 *
 * @var array<string, mixed>
 */
return array(

    /**
     * Paths to be used for database migration.
     *
     * @var array<string, string[]>
     */
    'paths' => array(

        /**
         * @var array
         */
        'migrations' => array(
            $root . '/src/Phinx/Scripts',
        ),

        /**
         * @var array
         */
        'seeds' => array(
            $root . '/src/Phinx/Seeders',
        ),

    ),

    /**
     * Returns an array of configurations exclusive
     * for a specified environment (e.g., "test").
     *
     * @var array
     */
    'environments' => array(

        /**
         * Name of the database table in storing the
         * logs during migration (e.g., "phinxlog").
         *
         * @var string
         */
        'default_migration_table' => 'phinxlog',

        /**
         * Defines the default configuration to be used
         * if the configuration is not specified when
         * running database migrations (e.g., "test").
         *
         * @var string
         */
        'default_database' => 'torin',

        /**
         * Configuration for the Torin package.
         *
         * @var array<string, string>
         */
        'torin' => array(

            /**
             * @var string
             */
            'adapter' => 'mysql',

            /**
             * @var string
             */
            'host' => getenv('TORIN_HOSTNAME'),

            /**
             * @var string
             */
            'name' => getenv('TORIN_DATABASE'),

            /**
             * @var string
             */
            'user' => getenv('TORIN_USERNAME'),

            /**
             * @var string
             */
            'pass' => getenv('TORIN_PASSWORD'),

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
            'adapter' => 'sqlite',

            /**
             * @var string
             */
            'name' => getenv('SQLITE_DATABASE'),

            /**
             * Suffix of the SQLite database file.
             *
             * @var string
             */
            'suffix' => '',

        ),

    ),

);
