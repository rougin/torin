<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Staticka\Render;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class Package implements IntegrationInterface
{
    /**
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        // Initialize the "RouterInterface" ---------------------
        $self = $this->setRouter();

        $name = 'Rougin\Slytherin\Routing\RouterInterface';

        if ($container->has($name))
        {
            /** @var \Rougin\Slytherin\Routing\RouterInterface */
            $temp = $container->get($name);

            $self = $temp->merge($self->routes());
        }

        $container = $container->set($name, $self);
        // ------------------------------------------------------

        // Initialize the "RenderInterface" -------
        /** @var string|string[] */
        $path = $config->get('app.views', '');

        $self = new Render($path);

        $name = 'Staticka\Render\RenderInterface';

        $container = $container->set($name, $self);
        // ----------------------------------------

        return $container;
    }

    /**
     * @return \Rougin\Slytherin\Routing\RouterInterface
     */
    abstract protected function setRouter();
}
