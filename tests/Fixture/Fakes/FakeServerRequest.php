<?php

namespace Rougin\Torin\Fixture\Fakes;

use Rougin\Slytherin\Http\ServerRequest;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FakeServerRequest extends ServerRequest
{
    /**
     * @var array<string, string>
     */
    protected $query = array();

    // Override constructor to avoid calling parent's constructor
    public function __construct()
    {
        // Do nothing, or initialize properties specific to the fake
        $this->server = array(); // Initialize parent's protected property to avoid errors if accessed
        $this->headers = array(); // Initialize parent's protected property
        $this->uri = new \Rougin\Slytherin\Http\Uri('/'); // Initialize parent's protected property
        $this->method = 'GET'; // Initialize parent's protected property
        $this->target = '/'; // Initialize parent's protected property
    }

    /**
     * @param array<string, string> $query
     *
     * @return self
     */
    public function withQueryParams($query)
    {
        $new = clone $this;
        $new->query = $query;
        return $new;
    }

    /**
     * @return array<string, string>
     */
    public function getQueryParams()
    {
        return $this->query;
    }
}
