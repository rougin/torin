<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Routing\Router;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Plates extends Package
{
    /**
     * @var string
     */
    protected $namespace = 'Rougin\Torin\Pages';

    /**
     * @var string
     */
    protected $prefix = '/';

    /**
     * @return \Rougin\Slytherin\Routing\RouterInterface
     */
    protected function setRouter()
    {
        $self = new Router;

        $self->prefix($this->prefix, $this->namespace);

        $self->get('/', 'Hello@index');

        $self->get('clients', 'Clients@index');

        $self->get('items', 'Items@index');

        $self->get('orders', 'Orders@index');

        return $self;
    }
}
