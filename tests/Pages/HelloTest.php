<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class HelloTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Hello
     */
    protected $page;

    /**
     * @return void
     */
    public function test_should_render_hello_page_output()
    {
        $expect = $this->getPlate('Hello');

        $actual = $this->page->index();

        $actual = $this->parseHtml($actual);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $plate = $this->withPlate();

        $http = $this->withHttp();

        $this->page = new Hello($plate, $http);
    }
}
