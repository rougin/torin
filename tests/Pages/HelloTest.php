<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Plate;
use Rougin\Torin\Routes\Hello;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class HelloTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Plate
     */
    protected $plate;

    /**
     * @var \Rougin\Torin\Routes\Hello
     */
    protected $route;

    /**
     * @return void
     */
    public function test_should_render_hello_page_output()
    {
        $expect = $this->findPlate('Hello');

        $actual = $this->route->page($this->plate);

        $actual = $this->parseHtml($actual);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $plate = $this->getPlate();

        $http = $this->withHttp();

        $this->plate = new Plate($plate, $http);

        $this->route = new Hello;
    }
}
