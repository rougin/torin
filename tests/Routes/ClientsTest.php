<?php

namespace Rougin\Torin\Routes;

use Rougin\Torin\Checks\ClientCheck;
use Rougin\Torin\Depots\ClientDepot;
use Rougin\Torin\Models\Client;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $depot;

    /**
     * @var \Rougin\Torin\Routes\Clients
     */
    protected $route;

    /**
     * @return void
     */
    public function test_failed_if_client_not_found()
    {
        $http = $this->withHttp('DELETE');

        $http = $this->route->delete(99, $http);

        $actual = $http->getStatusCode();

        $this->assertEquals(404, $actual);
    }

    /**
     * @return void
     */
    public function test_failed_if_create_client_invalid_data()
    {
        // Simulate an HTTP request ----------
        $data = array('remarks' => 'Remarks');

        $http = $this->withParsed($data);
        // -----------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->store($http);

        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if errors returned properly ---------
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string[]> */
        $data = json_decode($actual, true);

        $expect = 'Client Name is required';

        $this->assertEquals($expect, $data['name'][0]);

        $expect = 'Client Type is required';

        $this->assertEquals($expect, $data['type'][0]);
        // --------------------------------------------
    }

    /**
     * @return void
     */
    public function test_failed_if_update_client_invalid_data()
    {
        // Create a new client ---------------
        $data = array('name' => 'Test Clien');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request ------------
        $data = array('remarks' => 'Remarks');

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->update($item->id, $http);

        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if errors returned properly ---------
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string[]> */
        $data = json_decode($actual, true);

        $expect = 'Client Name is required';

        $this->assertEquals($expect, $data['name'][0]);

        $expect = 'Client Type is required';

        $this->assertEquals($expect, $data['type'][0]);
        // --------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_all_clients_via_index()
    {
        // Create new multiple clients -------
        $data = array('name' => 'Test Clie1');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Clie2');

        $data['type'] = Client::TYPE_SUPPLIER;

        $data['remarks'] = 'Test Remarks 2';

        $this->depot->create($data);
        // -----------------------------------

        $data = array('p' => 1, 'l' => 5);

        $http = $this->withParams($data);

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->index($http);

        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if clients returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $name1 = $data['items'][0]['name'];

        $this->assertEquals('Test Clie1', $name1);

        $name2 = $data['items'][1]['name'];

        $this->assertEquals('Test Clie2', $name2);
        // -------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_client_created_via_store()
    {
        // Simulate an HTTP request ----------
        $data = array('name' => 'Test Clien');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks';

        $http = $this->withParsed($data);
        // -----------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->store($http);

        $this->assertEquals(201, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if client was created in the database ------
        $actuals = $this->depot->all();

        $this->assertEquals($data['name'], $actuals[0]->name);
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_client_deleted_via_delete()
    {
        // Create a new client ---------------
        $data = array('name' => 'Test Clien');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Verify if it returns an HTTP response ----------
        $http = $this->withHttp('DELETE');

        $actual = $this->route->delete($item->id, $http);

        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify client was deleted from the database ---
        $exists = $this->depot->rowExists($item->id);

        $this->assertFalse($exists);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_client_updated_via_update()
    {
        // Create a new client ---------------
        $data = array('name' => 'Test Clien');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request ------------
        $data = array('name' => 'Updated Clie');

        $data['type'] = Client::TYPE_SUPPLIER;

        $data['remarks'] = 'Updated Remarks';

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->update($item->id, $http);

        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify client was updated in the database -----
        $actual = $this->depot->find($item->id);

        $this->assertEquals($data['name'], $actual->name);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_clients_select_via_select()
    {
        // Create new multiple clients -------
        $data = array('name' => 'Test Clie1');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Test Remarks 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Clie2');

        $data['type'] = Client::TYPE_SUPPLIER;

        $data['remarks'] = 'Test Remarks 2';

        $this->depot->create($data);
        // -----------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->select();

        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if selects returned properly ----
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string>[] */
        $data = json_decode($actual, true);

        $this->assertEquals(1, $data[0]['value']);

        $this->assertEquals(2, $data[1]['value']);
        // ----------------------------------------
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $depot = new ClientDepot(new Client);

        $check = new ClientCheck;

        $this->route = new Clients($check, $depot);

        $this->depot = $depot;
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->rollback();

        $this->shutdown();
    }
}
