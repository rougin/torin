<?php

namespace Rougin\Torin\Routes;

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
    public function test_failed_if_create_item_invalid_data()
    {
        // Simulate an HTTP request ----------
        $data = array('detail' => 'Details');

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

        $expect = 'Name is required';

        $this->assertEquals($expect, $data['name'][0]);
        // --------------------------------------------
    }

    /**
     * @return void
     */
    public function test_failed_if_item_not_found()
    {
        $http = $this->withHttp('DELETE');

        $http = $this->route->delete(99, $http);

        $actual = $http->getStatusCode();

        $this->assertEquals(404, $actual);
    }

    /**
     * @return void
     */
    public function test_failed_if_update_item_invalid_data()
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

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->update($item->id, $http);

        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

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
    public function test_passed_if_all_items_via_index()
    {
        // Create new multiple items ----------
        $data = array('name' => 'Test Item 1');

        $data['detail'] = 'Test Details 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Item 2');

        $data['detail'] = 'Test Details 2';

        $this->depot->create($data);
        // ------------------------------------

        // Simulate an HTTP request ------
        $data = array('p' => 1, 'l' => 5);

        $http = $this->withParams($data);
        // -------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->index($http);

        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if items returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $name1 = $data['items'][0]['name'];

        $this->assertEquals('Test Item 1', $name1);

        $name2 = $data['items'][1]['name'];

        $this->assertEquals('Test Item 2', $name2);
        // -----------------------------------------------
    }

    /**
     * PHP 5.4: Investigate filters in "index". Swap "Item 1"
     * with "Item 2" in order for the temporary fix.
     *
     * @return void
     */
    public function test_passed_if_filtered_items_via_index()
    {
        // Create new multiple items ----------
        $data = array('name' => 'Test Item 2');

        $data['detail'] = 'Test Details 2';

        $this->depot->create($data);

        $data = array('name' => 'Test Item 1');

        $data['detail'] = 'Test Details 1';

        $this->depot->create($data);
        // ------------------------------------

        // Simulate an HTTP request ---------
        $data = array('k' => 'item 2');

        $http = $this->withParams($data);

        $actual = $this->route->index($http);
        // ----------------------------------

        // Verify if items returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $name2 = $data['items'][0]['name'];
        $this->assertEquals('Test Item 2', $name2);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_item_created_via_store()
    {
        // Simulate an HTTP request ---------
        $data = array('name' => 'Test Item');

        $data['detail'] = 'Test Details';

        $http = $this->withParsed($data);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->store($http);

        $this->assertEquals(201, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if item was created in the database ---
        $actuals = $this->depot->all();

        $actual = $actuals[0]->name;

        $this->assertEquals($data['name'], $actual);
        // ----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_item_deleted_via_delete()
    {
        // Create a new item ----------------
        $data = array('name' => 'Test Item');

        $data['detail'] = 'Test Details';

        $item = $this->depot->create($data);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $http = $this->withHttp('DELETE');

        $actual = $this->route->delete($item->id, $http);

        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify item was deleted from the database ---
        $exists = $this->depot->rowExists($item->id);

        $this->assertFalse($exists);
        // ---------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_item_updated_via_update()
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

        // Verify if it returns an HTTP response ----------
        $actual = $this->route->update($item->id, $http);

        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify item was updated in the database -------
        $actual = $this->depot->find($item->id);

        $this->assertEquals($data['name'], $actual->name);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_items_select_via_select()
    {
        // Create new multiple items ----------
        $data = array('name' => 'Test Item 1');

        $data['detail'] = 'Test Details 1';

        $this->depot->create($data);

        $data = array('name' => 'Test Item 2');

        $data['detail'] = 'Test Details 2';

        $this->depot->create($data);
        // ------------------------------------

        // Verify if it returns an HTTP response ---
        $actual = $this->route->select();

        $status = $actual->getStatusCode();

        $this->assertEquals(200, $status);
        // -----------------------------------------

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
