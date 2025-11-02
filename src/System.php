<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\System as Slytherin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class System
{
    /**
     * @var \Rougin\Slytherin\Container\ContainerInterface
     */
    protected $app;

    /**
     * @var \Rougin\Slytherin\Integration\Configuration
     */
    protected $config;

    /**
     * @var string
     */
    protected $root = '';

    /**
     * @param string $root
     */
    public function __construct($root)
    {
        // Load variables from ".env" ---
        $env = new \Dotenv\Dotenv($root);

        $env->load();
        // ------------------------------

        $app = new Container;

        $this->root = $root;

        $this->setContainer($app);
    }

    /**
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function getContainer()
    {
        return $this->app;
    }

    /**
     * @param \Rougin\Slytherin\Container\ContainerInterface $app
     *
     * @return self
     */
    public function setContainer(ContainerInterface $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Creates an application instance with the packages.
     *
     * @return \Rougin\Slytherin\System
     */
    public function make()
    {
        // Load data from the "config" directory ---
        $config = new Configuration;

        $config->load($this->root . '/app/config');

        /** @var string[] */
        $packages = $config->get('app.packages');
        // -----------------------------------------

        $app = $this->getContainer();

        $app = new Slytherin($app, $config);

        return $app->integrate($packages);
    }
}
