<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Fixture\Fakes\FakeOrderDepot;
use Rougin\Torin\Fixture\Fakes\FakeServerRequest;
use Rougin\Torin\Fixture\Stubs\StubRender;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrdersTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Orders
     */
    protected $page;

    /**
     * @var \Rougin\Torin\Fixture\Stubs\StubRender
     */
    protected $plate;

    /**
     * @var \Rougin\Torin\Fixture\Fakes\FakeServerRequest
     */
    protected $request;

    /**
     * @return void
     */
    public function test_can_render_orders_index_page()
    {
        $depot = new FakeOrderDepot(10); // Set a total for pagination

        $this->request = $this->request->withQueryParams(array()); // Simulate no query parameters

        $result = $this->page->index($depot);

        $this->assertEquals('rendered_html_from_stub_render', $result);
        $this->assertEquals('orders/index', $this->plate->getTemplate());
        $this->assertArrayHasKey('depot', $this->plate->getData());
        $this->assertArrayHasKey('pagee', $this->plate->getData());
        $this->assertArrayHasKey('table', $this->plate->getData());
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->plate = new StubRender;
        $this->request = new FakeServerRequest;

        $this->page = new Orders($this->plate, $this->request);
    }
}
