<?php

namespace Rougin\Torin\Routes;

use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\ClientDepot;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Depots\OrderDepot;
use Rougin\Torin\Models\Client;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Models\Order;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrdersTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $client;

    /**
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $depot;

    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $item;

    /**
     * @var \Rougin\Torin\Routes\Orders
     */
    protected $route;

    /**
     * @return void
     */
    public function test_should_change_order_status()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 1;
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // ----------------------------------

        // Simulate an HTTP request ------------
        $expect = Order::STATUS_COMPLETED;

        $data = array('status' => $expect);

        $http = $this->withParsed($data, 'PUT');
        // -------------------------------------

        // Call the route method -------------------------
        $actual = $this->route->status($order->id, $http);
        // -----------------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify status was updated in the database ---
        $actual = $this->depot->find($order->id);

        $this->assertEquals($expect, $actual->status);
        // ---------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_check_cart_with_valid_data()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 10;
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // ----------------------------------

        // Mark the purchase order as completed --------
        $status = Order::STATUS_COMPLETED;

        $this->depot->changeStatus($order->id, $status);
        // ---------------------------------------------

        // Simulate an HTTP request ----------
        $data = array('item_id' => $item->id);
        $data['quantity'] = 10;
        $data['type'] = Order::TYPE_SALE;

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the route method -------------------------
        $actual = $this->route->check($this->item, $http);
        // -----------------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_create_order_via_store_method()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Simulate an HTTP request ----------------------
        $data = array('client_id' => $client->id);
        $data['type'] = Order::TYPE_PURCHASE;
        $data['remarks'] = 'Order Remarks';
        $cart = array('id' => $item->id, 'quantity' => 5);
        $data['cart'] = array($cart);

        $http = $this->withParsed($data);
        // -----------------------------------------------

        // Call the route method ------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(201, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify order was created in the database ------
        $actual = $this->depot->all();

        $expect = 'Order Remarks';
        $this->assertEquals($expect, $actual[0]->remarks);

        $expect = Order::TYPE_PURCHASE;
        $this->assertEquals($expect, $actual[0]->type);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_delete_order_via_delete_method()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 1;
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // ----------------------------------

        // Simulate an HTTP request ------
        $http = $this->withHttp('DELETE');
        // -------------------------------

        // Call the route method -------------------------
        $actual = $this->route->delete($order->id, $http);
        // -----------------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(204, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify order was deleted from the database ---
        $exists = $this->depot->rowExists($order->id);

        $this->assertFalse($exists);
        // ----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_get_all_orders_via_index_method()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 1;
        $data['cart'] = array($cart);

        $this->depot->create($data);
        // ----------------------------------

        // Create a new sales order -----
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_SALE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 2;
        $data['cart'] = array($cart);

        $this->depot->create($data);
        // ------------------------------

        // Simulate an HTTP request -------------------------
        $http = $this->withParams(array('p' => 1, 'l' => 5));
        // --------------------------------------------------

        // Call the route method ------------
        $actual = $this->route->index($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(200, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if items returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        /** @var array<string, array<string, string>[]> */
        $data = json_decode($actual, true);

        $remarks1 = $data['items'][0]['remarks'];
        $this->assertNull($remarks1);

        $remarks2 = $data['items'][1]['remarks'];
        $this->assertNull($remarks2);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_check_cart_with_invalid_data()
    {
        // Simulate an HTTP request -----
        $data = array('item_id' => 9999);
        $data['quantity'] = 10;
        $data['type'] = Order::TYPE_SALE;

        $http = $this->withParsed($data);
        // ------------------------------

        // Call the route method -------------------------
        $actual = $this->route->check($this->item, $http);
        // -----------------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if items returned from HTTP response ---
        $actual = $actual->getBody()->__toString();

        $this->assertEquals('"Item not found"', $actual);
        // -----------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_check_cart_with_invalid_quantity()
    {
        // Create a new client and item -------
        $data = array();
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['name'] = 'Test Client';
        $data['remarks'] = 'Test Remarks';

        $client = $this->client->create($data);

        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Details';

        $item = $this->item->create($data);
        // ------------------------------------

        // Create a new purchase order -------------------
        $data = array('client_id' => $client->id);
        $data['type'] = Order::TYPE_PURCHASE;
        $data['remarks'] = 'Purchase Remarks';
        $cart = array('id' => $item->id, 'quantity' => 1);
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // -----------------------------------------------

        // Mark the purchase order as completed --------
        $status = Order::STATUS_COMPLETED;

        $this->depot->changeStatus($order->id, $status);
        // ---------------------------------------------

        // Simulate an HTTP request ----------
        $data = array('item_id' => $item->id);
        $data['quantity'] = 100;
        $data['type'] = Order::TYPE_SALE;

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the route method -------------------------
        $actual = $this->route->check($this->item, $http);
        // -----------------------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if items returned from HTTP response -------
        $actual = $actual->getBody()->__toString();

        $this->assertEquals('"Not enough quantity"', $actual);
        // ---------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_create_order_with_invalid_data()
    {
        // Simulate an HTTP request ----------
        $data = array('remarks' => 'Remarks');

        $http = $this->withParsed($data);
        // -----------------------------------

        // Call the route method ------------
        $actual = $this->route->store($http);
        // ----------------------------------

        // Verify if it returns an HTTP response ----------
        $this->assertEquals(422, $actual->getStatusCode());
        // ------------------------------------------------

        // Verify if errors returned properly --------------
        $actual = $actual->getBody()->__toString();

        /** @var array<string, string[]> */
        $data = json_decode($actual, true);

        $expect = 'Cart is required';
        $this->assertEquals($expect, $data['cart'][0]);

        $expect = 'Client Name is required';
        $this->assertEquals($expect, $data['client_id'][0]);

        $expect = 'Order Type is required';
        $this->assertEquals($expect, $data['type'][0]);
        // -------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_delete_non_existent_order()
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
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $depot = new OrderDepot(new Order);

        $check = new OrderCheck;

        $this->route = new Orders($check, $depot);

        $this->depot = $depot;

        // Initialize the other related depots ---
        $depot = new ClientDepot(new Client);

        $this->client = $depot;

        $this->item = new ItemDepot(new Item);
        // ---------------------------------------
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
