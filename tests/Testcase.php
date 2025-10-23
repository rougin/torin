<?php

namespace Rougin\Torin;

use LegacyPHPUnit\TestCase as Legacy;
use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Rougin\Slytherin\Http\ServerRequest;
use Staticka\Render;
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
     * @var \Staticka\Render
     */
    protected $plate;

    /**
     * @var \Rougin\Slytherin\Http\ServerRequest
     */
    protected $request;

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getPlate($name)
    {
        $path = __DIR__ . '/Fixture/Plates';

        $file = $path . '/' . $name . '.html';

        /** @var string */
        return file_get_contents($file);
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
    protected function shutdown()
    {
        $this->capsule->getConnection('torin')->disconnect();
    }

    /**
     * @return void
     */
    protected function startUp()
    {
        $capsule = new Capsule;

        $data = array('prefix' => '');
        $data['database'] = ':memory:';
        $data['driver'] = 'sqlite';

        $capsule->addConnection($data, 'torin');

        // PHP 5.4: Requires to add a "default" ---
        // connection prior to Laravel 5.1 --------
        $capsule->addConnection($data);
        // ----------------------------------------

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->capsule = $capsule;
    }

    /**
     * @param string $method
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function withHttp($method = 'GET')
    {
        $server = array('REQUEST_METHOD' => $method);

        $server['REQUEST_URI'] = '/';
        $server['SERVER_NAME'] = 'localhost';
        $server['SERVER_PORT'] = '80';

        return new ServerRequest($server);
    }

    /**
     * @param array<string, mixed> $items
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function withParams($items)
    {
        $http = $this->withHttp();

        return $http->withQueryParams($items);
    }

    /**
     * @param array<string, mixed> $items
     * @param string               $method
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function withParsed($items, $method = 'POST')
    {
        $http = $this->withHttp($method);

        return $http->withParsedBody($items);
    }

    /**
     * @return \Staticka\Render
     */
    protected function withPlate()
    {
        $paths = array();

        $paths[] = __DIR__ . '/../app/assets';
        $paths[] = __DIR__ . '/../app/plates';

        return new Render($paths);
    }

    /**
     * @param string $pattern
     * @param string $string
     *
     * @return void
     */
    protected function assertRegex($pattern, $string)
    {
        $method = 'assertMatchesRegularExpression';

        if (method_exists($this, $method))
        {
            $this->assertMatchesRegularExpression($pattern, $string);

            return;
        }

        $this->assertRegExp($pattern, $string);
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
