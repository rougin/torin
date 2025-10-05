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
     * @return void
     */
    public function test_page_output()
    {
        $this->withPlate();
        $this->withHttp();

        $page = new Hello($this->plate, $this->request);

        $expect = $this->getPlate('Hello');

        $actual = $page->index();

        $this->assertEquals($expect, $actual);
    }
}
