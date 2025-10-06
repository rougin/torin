<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $depot;

    /**
     * @var \Rougin\Torin\Routes\Items
     */
    protected $route;

    /**
     * @return void
     */
    public function test_can_create_item_with_store_method()
    {
        // Simulate an HTTP request ---------
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $http = $this->withParsed($data);
        // ----------------------------------

        // Call the route method ------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(201, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify if item was created in the database --------
        $actuals = $this->depot->all();

        $this->assertCount(1, $actuals);

        $this->assertEquals($data['name'], $actuals[0]->name);
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_delete_item_with_delete_method()
    {
        // Create a new item ----------------
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->depot->create($data);
        // ----------------------------------

        // Simulate an HTTP request ------
        $http = $this->withHttp('DELETE');
        // -------------------------------

        // Call the route method ------------------------
        $actual = $this->route->delete($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(204, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify item was deleted from the database ---
        $exists = $this->depot->rowExists($item->id);

        $this->assertFalse($exists);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_get_all_items_with_index_method()
    {
        // Create new multiple items ----------
        $data = array('name' => 'Test Item 1');
        $data['detail'] = 'Test Details 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Item 2');
        $data['detail'] = 'Test Details 2';

        $this->depot->create($data);
        // ------------------------------------

        // Simulate an HTTP request ---
        $http = $this->withHttp();
        // ----------------------------

        // Call the route method ------------
        $actual = $this->route->index($http);
        // ----------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(200, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify if items returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $this->assertCount(2, $data['items']);

        $name1 = $data['items'][0]['name'];
        $this->assertEquals('Test Item 1', $name1);

        $name2 = $data['items'][1]['name'];
        $this->assertEquals('Test Item 2', $name2);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_get_items_for_select_method()
    {
        // Create new multiple items ----------
        $data = array('name' => 'Test Item 1');
        $data['detail'] = 'Test Details 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Item 2');
        $data['detail'] = 'Test Details 2';

        $this->depot->create($data);
        // ------------------------------------

        // Call the route method --------
        $actual = $this->route->select();
        // ------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(200, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify if selects returned properly ----
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string>[] */
        $data = json_decode($actual, true);

        $this->assertCount(2, $data);

        $this->assertEquals(1, $data[0]['value']);

        $this->assertEquals(2, $data[1]['value']);
        // ----------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_update_item_with_update_method()
    {
        // Create a new item ----------------
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->depot->create($data);
        // ----------------------------------

        // Simulate an HTTP request ------------
        $data = array('name' => 'Updated Item');
        $data['detail'] = 'Updated Details';

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Call the route method ------------------------
        $actual = $this->route->update($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(204, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify item was updated in the database -----------
        $actual = $this->depot->find($item->id);

        $this->assertEquals($data['detail'], $actual->detail);

        $this->assertEquals($data['name'], $actual->name);
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_cannot_create_item_with_invalid_data()
    {
        // Simulate an HTTP request ----------
        $data = array('detail' => 'Details');

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the method ------------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(422, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify if errors returned properly ---------
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string[]> */
        $data = json_decode($actual, true);

        $expect = 'Name is required';
        $this->assertEquals($expect, $data['name'][0]);
        // --------------------------------------------
    }

    /**
     * @return void
     */
    public function test_cannot_delete_non_existent_item()
    {
        // Simulate an HTTP request ------
        $http = $this->withHttp('DELETE');
        // -------------------------------

        // Call the route method -----------------
        $actual = $this->route->delete(99, $http);
        // ---------------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(422, $actual->getStatusCode());
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_cannot_update_item_with_invalid_data()
    {
        // Create a new item ----------------
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->depot->create($data);
        // ----------------------------------

        // Simulate an HTTP request ------------
        $data = array('name' => 'Updated Item');

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Call the route method ------------------------
        $actual = $this->route->update($item->id, $http);
        // ----------------------------------------------

        // Verify if it returns an HTTP response -------------
        $this->assertInstanceOf(JsonResponse::class, $actual);

        $this->assertEquals(422, $actual->getStatusCode());
        // ---------------------------------------------------

        // Verify if errors returned properly -----------
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string[]> */
        $data = json_decode($actual, true);

        $expect = 'Description is required';
        $this->assertEquals($expect, $data['detail'][0]);
        // ----------------------------------------------
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $depot = new ItemDepot(new Item);

        $check = new ItemCheck;

        $this->route = new Items($check, $depot);

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
