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
    public function test_should_create_client_via_store_method()
    {
        // Simulate an HTTP request ----------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the route method ------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
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
    public function test_should_delete_client_via_delete_method()
    {
        // Create a new client ---------------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request ------
        $http = $this->withHttp('DELETE');
        // -------------------------------

        // Call the route method ------------------------
        $actual = $this->route->delete($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response ----------
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
    public function test_should_get_all_clients_via_index_method()
    {
        // Create new multiple clients -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client 1';
        $data['remarks'] = 'Test Remarks 1';

        $this->depot->create($data);

        $data = array();
        $data['type'] = Client::TYPE_SUPPLIER;
        $data['name'] = 'Test Client 2';
        $data['remarks'] = 'Test Remarks 2';

        $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request -------------------------
        $http = $this->withParams(array('p' => 1, 'l' => 5));
        // --------------------------------------------------

        // Call the route method ------------
        $actual = $this->route->index($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if clients returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $name1 = $data['items'][0]['name'];
        $this->assertEquals('Test Client 1', $name1);

        $name2 = $data['items'][1]['name'];
        $this->assertEquals('Test Client 2', $name2);
        // -------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_get_clients_for_select_via_select_method()
    {
        // Create new multiple clients -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client 1';
        $data['remarks'] = 'Test Remarks 1';

        $this->depot->create($data);

        $data = array();
        $data['type'] = Client::TYPE_SUPPLIER;
        $data['name'] = 'Test Client 2';
        $data['remarks'] = 'Test Remarks 2';

        $this->depot->create($data);
        // -----------------------------------

        // Call the route method --------
        $actual = $this->route->select();
        // ------------------------------

        // Verify if it returns an HTTP response ----------
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
    public function test_should_update_client_via_update_method()
    {
        // Create a new client ---------------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request ------------
        $data = array();
        $data['type'] = Client::TYPE_SUPPLIER;
        $data['name'] = 'Updated Client';
        $data['remarks'] = 'Updated Remarks';

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Call the route method ------------------------
        $actual = $this->route->update($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response ----------
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
    public function test_should_not_create_client_with_invalid_data()
    {
        // Simulate an HTTP request ----------
        $data = array('remarks' => 'Remarks');

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the method ------------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
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
    public function test_should_not_delete_non_existent_client()
    {
        // Simulate an HTTP request ------
        $http = $this->withHttp('DELETE');
        // -------------------------------

        // Call the route method -----------------
        $actual = $this->route->delete(99, $http);
        // ---------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_update_client_with_invalid_data()
    {
        // Create a new client ---------------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $item = $this->depot->create($data);
        // -----------------------------------

        // Simulate an HTTP request ------------
        $data = array('remarks' => 'Remarks');

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Call the route method ------------------------
        $actual = $this->route->update($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response ----------
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
