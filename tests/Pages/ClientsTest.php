<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Fixture\Fakes\FakeClientDepot;
use Rougin\Torin\Fixture\Fakes\FakePlate;
use Rougin\Torin\Fixture\Fakes\FakeServerRequest;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Clients
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
    public function test_can_render_clients_index_page()
    {
        $depot = new FakeClientDepot(10); // Set a total for pagination

        $this->request = $this->request->withQueryParams(array()); // Simulate no query parameters

        $result = $this->page->index($depot);

        $this->assertEquals('rendered_html_from_fake_plate', $result);
        $this->assertEquals('clients.index', $this->plate->getTemplate());
        $this->assertArrayHasKey('depot', $this->plate->getData());
        $this->assertArrayHasKey('pagee', $this->plate->getData());
        $this->assertArrayHasKey('table', $this->plate->getData());
        // Further assertions on the structure of 'pagee' and 'table' if needed
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->plate = new FakePlate;
        $this->request = new FakeServerRequest;

        $this->page = new Clients($this->plate, $this->request);
    }
}
