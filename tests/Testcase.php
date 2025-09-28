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
     * @param string $pattern
     * @param string $string
     *
     * @return void
     */
    public function assertRegex($pattern, $string)
    {
        $this->assertMatchesRegularExpression($pattern, $string);
    }

    /**
     * @return void
     */
    protected function migrate()
    {
        $phinx = $this->setPhinx();

        $paths = $phinx->getConfig()->getMigrationPaths();

        // Return the latest version (e.g., '20241213094622') ---
        $version = $this->getLastVersion($paths);
        // ------------------------------------------------------

        // Run the migration up to the specified version ---
        $phinx->migrate('test', $version);
        // -------------------------------------------------
    }

    /**
     * @return void
     */
    protected function rollback()
    {
        $this->setPhinx()->migrate('test', 0);
    }

    /**
     * @return \Phinx\Migration\Manager
     */
    protected function setPhinx()
    {
        // Prepare the PDO to the configuration file -----------
        $data = require __DIR__ . '/../app/config/phinx.php';

        $pdo = $this->capsule->getConnection('torin')->getPdo();

        $data['environments']['test']['connection'] = $pdo;

        $config = new Config($data);
        // -----------------------------------------------------

        $input = new ArrayInput(array());

        $output = new NullOutput;

        return new Manager($config, $input, $output);
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

        $this->migrate();
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->rollback();

        $this->capsule->getConnection('torin')->disconnect();
    }

    /**
     * @param string[] $paths
     *
     * @return integer
     */
    protected function getLastVersion($paths)
    {
        $version = 0;

        foreach ($paths as $path)
        {
            /** @var string[] */
            $files = glob($path . '/*.php');

            foreach ($files as $file)
            {
                $temp = basename($file, '.php');

                $version = substr($temp, 0, 14);

                $version = (int) $version;
            }
        }

        return $version;
    }
}
