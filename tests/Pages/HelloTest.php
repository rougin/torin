<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Fixture\Stubs\StubRender;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class HelloTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Fixture\Stubs\StubRender
     */
    protected $plate;

    /**
     * @return void
     */
    public function test_can_render_hello_index_page()
    {
        $this->plate = new StubRender;

        $page = new Hello;
        $result = $page->index($this->plate);

        $this->assertEquals('rendered_html_from_stub_render', $result);
        $this->assertEquals('index', $this->plate->getTemplate());
    }
}
