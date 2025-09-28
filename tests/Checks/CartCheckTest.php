<?php

namespace Rougin\Torin\Checks;

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
class CartCheckTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Checks\CartCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $client;

    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $item;

    /**
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $order;

    /**
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $item = array();
        $item[] = array('quantity' => 10, 'type' => Order::TYPE_SALE);
        $item[] = 'An item is required';
        $items[] = $item;

        $item = array();
        $item[] = array('item_id' => 1, 'type' => Order::TYPE_SALE);
        $item[] = 'Quantity is required';
        $items[] = $item;

        $item = array();
        $item[] = array('item_id' => 1, 'quantity' => 10);
        $item[] = 'Order Type is required';
        $items[] = $item;

        return $items;
    }

    /**
     * @dataProvider for_errors_provider
     *
     * @param array<string, mixed> $data
     * @param string               $text
     *
     * @return void
     */
    public function test_for_errors($data, $text)
    {
        $actual = $this->check->valid($data);

        $this->assertFalse($actual);

        $actual = $this->check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_item_not_found_error()
    {
        $data = array('item_id' => 999);
        $data['quantity'] = 10;
        $data['type'] = Order::TYPE_SALE;

        $actual = $this->check->valid($data);

        $this->assertFalse($actual);

        $actual = $this->check->firstError();

        $expect = 'Item not found';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_for_not_enough_quantity_error()
    {
        // Create a new item --------------
        $data = array('name' => 'Test');
        $data['detail'] = 'Test';
        $item = $this->item->create($data);
        // --------------------------------

        // Create a new client ----------------
        $data = array('name' => 'Test');
        $data['address'] = 'Test';
        $client = $this->client->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => '');
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 5;
        $data['cart'] = array($cart);

        $order = $this->order->create($data);
        // ----------------------------------

        $this->order->changeStatus($order->id, Order::STATUS_COMPLETED);

        $data = array('quantity' => 10);
        $data['item_id'] = $item->id;
        $data['type'] = Order::TYPE_SALE;

        $actual = $this->check->valid($data);

        $this->assertFalse($actual);

        $actual = $this->check->firstError();

        $expect = 'Not enough quantity';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed_check()
    {
        // Create a new item --------------
        $data = array('name' => 'Test');
        $data['detail'] = 'Test';
        $item = $this->item->create($data);
        // --------------------------------

        // Create a new client ----------------
        $data = array('name' => 'Test');
        $data['address'] = 'Test';
        $client = $this->client->create($data);
        // ------------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => '');
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 20;
        $data['cart'] = array($cart);

        $order = $this->order->create($data);
        // ----------------------------------

        $this->order->changeStatus($order->id, Order::STATUS_COMPLETED);

        $data = array('quantity' => 10);
        $data['item_id'] = $item->id;
        $data['type'] = Order::TYPE_SALE;

        $actual = $this->check->valid($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->client = new ClientDepot(new Client);

        $this->item = new ItemDepot(new Item);

        $this->order = new OrderDepot(new Order);

        $this->check = new CartCheck($this->item);
    }
}
