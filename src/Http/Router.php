<?php

namespace Rougin\Torin\Http;

use Rougin\Slytherin\Routing\Router as Slytherin;
use Rougin\Torin\Package;

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
    protected $namespace = 'Rougin\Torin\Http\Routes';

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

        $self->get('clients/select', 'Clients@select');

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

        // Order ----------------------------
        $self->get('orders', 'Orders@index');
        // ----------------------------------

        return $self;
    }
}