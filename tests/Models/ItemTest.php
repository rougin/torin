<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemTest extends Testcase
{
    /**
     * @return void
     */
    public function test_can_create_an_item()
    {
        $model = new Item;

        $data = array('name' => 'Item A');
        $data['detail'] = 'Detail A';
        $actual = $model->create($data)->name;

        $this->assertEquals('Item A', $actual);
    }

    /**
     * @return void
     */
    public function test_can_find_an_item()
    {
        $model = new Item;

        $data = array('name' => 'Item B');
        $data['detail'] = 'Detail B';
        $model->create($data);

        $model = $model->where('name', 'Item B');
        $actual = $model->firstOrFail()->name;

        $this->assertEquals('Item B', $actual);
    }

    /**
     * @return void
     */
    public function test_can_get_created_at()
    {
        $model = new Item;

        $data = array('name' => 'Item E');
        $data['detail'] = 'Detail E';
        $actual = $model->create($data)->created_at;

        $expect = date('d M Y h:i A', time());
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_can_get_item_as_row()
    {
        $model = new Item;

        $data = array('name' => 'Item C');
        $data['detail'] = 'Detail C';
        $item = $model->create($data);

        $actual = $item->asRow();

        $this->assertEquals($item->id, $actual['id']);
        $this->assertEquals('Detail C', $actual['detail']);
        $this->assertEquals('Item C', $actual['name']);
    }

    /**
     * @return void
     */
    public function test_can_get_item_as_select()
    {
        $model = new Item;

        $data = array('name' => 'Item D');
        $data['detail'] = 'Detail D';
        $item = $model->create($data);

        $actual = $item->asSelect();

        $this->assertEquals($item->id, $actual['value']);
        $this->assertEquals('Item D', $actual['label']);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_mixed_orders()
    {
        $model = new Item;

        $data = array('name' => 'Item J');
        $data['detail'] = 'Detail J';
        $item = $model->create($data);

        $model = new Order;

        // Create a new purchase order -----------
        $data = array('code' => 'ORD-005');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_PURCHASE;
        $purchase = $model->create($data);

        $item->addOrder($purchase->id, 20);
        // ---------------------------------------

        // Create a new sales order --------------
        $data = array('code' => 'ORD-006');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_SALE;
        $sale = $model->create($data);

        $item->addOrder($sale->id, 12);
        // ---------------------------------------

        // 20 (from purchase) - 12 (from sales) ---
        $this->assertEquals(8, $item->quantity);
        // ----------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_no_orders()
    {
        $model = new Item;

        $data = array('name' => 'Item G');
        $data['detail'] = 'Detail G';
        $item = $model->create($data);

        $this->assertEquals(0, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_pending_orders()
    {
        $model = new Item;

        $data = array('name' => 'Item K');
        $data['detail'] = 'Detail K';
        $item = $model->create($data);

        $model = new Order;

        // Create a new purchase order ---------
        $data = array('code' => 'ORD-007');
        $data['status'] = Order::STATUS_PENDING;
        $data['type'] = Order::TYPE_PURCHASE;
        $purchase = $model->create($data);

        $item->addOrder($purchase->id, 10);
        // -------------------------------------

        // Create a new sales order --------------
        $data = array('code' => 'ORD-008');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_SALE;
        $sale = $model->create($data);

        $item->addOrder($sale->id, 5);
        // ---------------------------------------

        // 0 (from purchase since its still pending) - 5 (from sales) ---
        $this->assertEquals(-5, $item->quantity);
        // --------------------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_purchase_orders()
    {
        $model = new Item;

        $data = array('name' => 'Item H');
        $data['detail'] = 'Detail H';
        $item = $model->create($data);

        $model = new Order;

        // Create a new purchase order -----------
        $data = array('code' => 'ORD-001');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_PURCHASE;
        $purchase = $model->create($data);

        $item->addOrder($purchase->id, 10);
        // ---------------------------------------

        // Create another purchase order ---------
        $data = array('code' => 'ORD-002');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_PURCHASE;
        $purchase = $model->create($data);

        $item->addOrder($purchase->id, 5);
        // ---------------------------------------

        $this->assertEquals(15, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_sale_orders()
    {
        $model = new Item;

        $data = array('name' => 'Item I');
        $data['detail'] = 'Detail I';
        $item = $model->create($data);

        $model = new Order;

        // Create a new sales order --------------
        $data = array('code' => 'ORD-003');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_SALE;
        $sale = $model->create($data);

        $item->addOrder($sale->id, 7);
        // ---------------------------------------

        // Create another sales order ------------
        $data = array('code' => 'ORD-004');
        $data['status'] = Order::STATUS_COMPLETED;
        $data['type'] = Order::TYPE_SALE;
        $sale = $model->create($data);

        $item->addOrder($sale->id, 3);
        // ---------------------------------------

        $this->assertEquals(-10, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_updated_at()
    {
        $model = new Item;

        $data = array('name' => 'Item F');
        $data['detail'] = 'Detail F';
        $actual = $model->create($data)->created_at;

        $expect = date('d M Y h:i A', time());
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();
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
