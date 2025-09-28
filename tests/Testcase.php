<?php

namespace Rougin\Torin;

use LegacyPHPUnit\TestCase as Legacy;
use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $capsule;

    /**
     * @param string $file
     * @param string $name
     *
     * @return boolean
     */
    protected function isPhinxFileExists($file, $name)
    {
        // Convert text casing to "snake_case" -------------
        /** @var string */
        $text = preg_replace('/(?<!^)[A-Z]/', '_$0', $name);

        $temp = strtolower($text);
        // -------------------------------------------------

        $file = basename($file, '.php');

        return strpos(strtolower($file), $temp) !== false;
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $capsule = new Capsule;

        $data = array('prefix' => '');
        $data['database'] = ':memory:';
        $data['driver'] = 'sqlite';

        $capsule->addConnection($data, 'torin');

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->capsule = $capsule;
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->capsule->getConnection('torin')->disconnect();
    }

    /**
     * @param string[] $paths
     * @param string   $name
     *
     * @return integer
     */
    protected function findPhinxVersion($paths, $name)
    {
        foreach ($paths as $path)
        {
            /** @var string[] */
            $files = glob($path . '/*.php');

            foreach ($files as $file)
            {
                if ($this->isPhinxFileExists($file, $name))
                {
                    $temp = basename($file, '.php');

                    return (int) substr($temp, 0, 14);
                }
            }
        }

        $error = 'Migration "' . $name . '" not found';

        throw new \Exception($error);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function runPhinx($name)
    {
        // Prepare the PDO to the configuration file -----------
        $data = require __DIR__ . '/../app/config/phinx.php';

        $pdo = $this->capsule->getConnection('torin')->getPdo();

        $data['environments']['test']['connection'] = $pdo;

        $config = new Config($data);
        // -----------------------------------------------------

        // Initialize the Manager with the created Config ---
        $input = new ArrayInput(array());

        $output = new NullOutput;

        $manager = new Manager($config, $input, $output);
        // --------------------------------------------------

        $paths = $config->getMigrationPaths();

        // Return the version from the migration class (e.g., '20241213094622') ---
        $version = $this->findPhinxVersion($paths, $name);
        // ------------------------------------------------------------------------

        // Run the migration up to the specified version ---
        $manager->migrate('test', $version);
        // -------------------------------------------------
    }
}
