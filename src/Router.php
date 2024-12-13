<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Routing\Router as Slytherin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Router extends Package
{
    /**
     * @var string
     */
    protected $namespace = 'Rougin\Torin\Routes';

    /**
     * @var string
     */
    protected $prefix = '/v1/';

    /**
     * @return \Rougin\Slytherin\Routing\RouterInterface
     */
    protected function setRouter()
    {
        $self = new Slytherin;

        $self->prefix($this->prefix, $this->namespace);

        // Client -------------------------------------
        $self->delete('clients/:id', 'Clients@delete');

        $self->get('clients', 'Clients@index');

        $self->put('clients/:id', 'Clients@update');

        $self->post('clients', 'Clients@store');
        // --------------------------------------------

        // Item -----------------------------------
        $self->delete('items/:id', 'Items@delete');

        $self->get('items', 'Items@index');

        $self->put('items/:id', 'Items@update');

        $self->post('items', 'Items@store');
        // ----------------------------------------

        return $self;
    }
}
