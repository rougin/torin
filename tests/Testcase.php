<?php

namespace Rougin\Torin;

use Illuminate\Database\Capsule\Manager as Capsule;
use LegacyPHPUnit\TestCase as Legacy;
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Container\ReflectionContainer;
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
     * @param string $pattern
     * @param string $string
     *
     * @return void
     */
    public function doAssertRegex($pattern, $string)
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
     * @param string $name
     *
     * @return string
     */
    protected function getPlate($name)
    {
        $path = __DIR__ . '/Fixture/Plates';

        $file = $path . '/' . $name . '.html';

        /** @var string */
        $html = file_get_contents($file);

        return $this->parseHtml($html);
    }

    /**
     * @return void
     */
    protected function migrate()
    {
        $phinx = $this->setPhinx();

        $phinx->migrate('test');
    }

    /**
     * Replaces "\r\n" to "\n" for Windows machines.
     *
     * @param string $html
     *
     * @return string
     */
    protected function parseHtml($html)
    {
        return str_replace("\r\n", "\n", $html);
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
        $app = new Container;

        // Prepare the PDO to the configuration file -----------
        $data = require __DIR__ . '/../app/config/phinx.php';

        $pdo = $this->capsule->getConnection('torin')->getPdo();

        $data['environments']['test']['connection'] = $pdo;

        $config = new \Phinx\Config\Config($data);

        $app->set('Phinx\Config\ConfigInterface', $config);
        // -----------------------------------------------------

        // Prepare the default Input and Output classes -------------
        $input = 'Symfony\Component\Console\Input\InputInterface';
        $app->set($input, new ArrayInput(array()));

        $output = 'Symfony\Component\Console\Output\OutputInterface';
        $app->set($output, new NullOutput);
        // ----------------------------------------------------------

        // PHP 5.3 - Use "Reflection API" for "Manager" as ---
        // it has different arguments in "v0.6.0" onwards ----
        $reflect = new ReflectionContainer($app);

        /** @var \Phinx\Migration\Manager */
        return $reflect->get('Phinx\Migration\Manager');
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    protected function shutdown()
    {
        // PHP 5.3 - "disconnect" is an undefined method -------
        // $this->capsule->getConnection('torin')->disconnect();
        // -----------------------------------------------------
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
     * @param string $uri
     * @param string $method
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    protected function withHttp($uri = '/', $method = 'GET')
    {
        $data = array();

        $data['HTTP_HOST'] = 'localhost';
        $data['REQUEST_METHOD'] = $method;
        $data['REQUEST_URI'] = $uri;
        $data['SERVER_NAME'] = 'localhost';
        $data['SERVER_PORT'] = '80';

        return new ServerRequest($data);
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
        $http = $this->withHttp('/', $method);

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
}
