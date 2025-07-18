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
    protected $container;

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

        $this->root = $root;

        $this->setContainer(new Container);
    }

    /**
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     *
     * @return self
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Creates an application instance with the packages.
     *
     * @return \Rougin\Slytherin\System
     */
    public function make()
    {
        $container = $this->getContainer();

        // Loads data from the "config" directory ---
        $config = new Configuration;

        $config->load($this->root . '/app/config');

        /** @var string[] */
        $packages = $config->get('app.packages');
        // ------------------------------------------

        $app = new Slytherin($container, $config);

        return $app->integrate($packages);
    }
}
