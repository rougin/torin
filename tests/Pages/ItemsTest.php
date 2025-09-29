<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Fixture\Fakes\FakeItemDepot;
use Rougin\Torin\Fixture\Fakes\FakePlate;
use Rougin\Torin\Fixture\Fakes\FakeServerRequest;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Items
     */
    protected $page;

    /**
     * @var \Rougin\Torin\Fixture\Fakes\FakePlate
     */
    protected $plate;

    /**
     * @var \Rougin\Torin\Fixture\Fakes\FakeServerRequest
     */
    protected $request;

    /**
     * @return void
     */
    public function test_can_render_items_index_page()
    {
        $depot = new FakeItemDepot(10); // Set a total for pagination

        $this->request = $this->request->withQueryParams(array()); // Simulate no query parameters

        $result = $this->page->index($depot);

        $this->assertEquals('rendered_html_from_fake_plate', $result);
        $this->assertEquals('items.index', $this->plate->getTemplate());
        $this->assertArrayHasKey('depot', $this->plate->getData());
        $this->assertArrayHasKey('pagee', $this->plate->getData());
        $this->assertArrayHasKey('table', $this->plate->getData());
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->plate = new FakePlate;
        $this->request = new FakeServerRequest;

        $this->page = new Items($this->plate, $this->request);
    }
}
