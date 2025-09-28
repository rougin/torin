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

        $item = $model->create(['name' => 'Item A', 'detail' => 'Detail A']);

        $this->assertNotNull($item->id);
        $this->assertEquals('Item A', $item->name);
    }

    /**
     * @return void
     */
    public function test_can_find_an_item()
    {
        $model = new Item;

        $model->create(['name' => 'Item B', 'detail' => 'Detail B']);

        $item = $model->where('name', 'Item B')->first();

        $this->assertNotNull($item);
        $this->assertEquals('Item B', $item->name);
    }

    /**
     * @return void
     */
    public function test_can_get_created_at()
    {
        $model = new Item;

        $current = time();

        $item = $model->create(['name' => 'Item E', 'detail' => 'Detail E']);

        $date = date('d M Y h:i A', $current);

        $this->assertEquals($date, $item->created_at);
    }

    /**
     * @return void
     */
    public function test_can_get_item_as_row()
    {
        $model = new Item;

        $item = $model->create(['name' => 'Item C', 'detail' => 'Detail C']);

        $row = $item->asRow();

        $this->assertArrayHasKey('id', $row);
        $this->assertEquals($item->id, $row['id']);
        $this->assertEquals('Item C', $row['name']);
        $this->assertEquals('Detail C', $row['detail']);
        $this->assertArrayHasKey('code', $row);
        $this->assertArrayHasKey('quantity', $row);
        $this->assertArrayHasKey('created_at', $row);
        $this->assertArrayHasKey('updated_at', $row);
    }

    /**
     * @return void
     */
    public function test_can_get_item_as_select()
    {
        $model = new Item;

        $item = $model->create(['name' => 'Item D', 'detail' => 'Detail D']);

        $select = $item->asSelect();

        $this->assertArrayHasKey('value', $select);
        $this->assertEquals($item->id, $select['value']);
        $this->assertArrayHasKey('label', $select);
        $this->assertEquals('Item D', $select['label']);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_mixed_orders()
    {
        $model = new Item;
        $item = $model->create(['name' => 'Item J', 'detail' => 'Detail J']);

        $model = new Order;
        $purchaseOrder = $model->create(['code' => 'ORD-005', 'type' => Order::TYPE_PURCHASE, 'status' => Order::STATUS_COMPLETED]);
        $saleOrder = $model->create(['code' => 'ORD-006', 'type' => Order::TYPE_SALE, 'status' => Order::STATUS_COMPLETED]);

        $item->orders()->attach($purchaseOrder->id, ['quantity' => 20]);
        $item->orders()->attach($saleOrder->id, ['quantity' => 12]);

        $item->load('orders');

        $this->assertEquals(8, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_no_orders()
    {
        $model = new Item;

        $item = $model->create(['name' => 'Item G', 'detail' => 'Detail G']);

        $this->assertEquals(0, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_pending_orders()
    {
        $model = new Item;
        $item = $model->create(['name' => 'Item K', 'detail' => 'Detail K']);

        $model = new Order;
        $purchaseOrder = $model->create(['code' => 'ORD-007', 'type' => Order::TYPE_PURCHASE, 'status' => Order::STATUS_PENDING]);
        $saleOrder = $model->create(['code' => 'ORD-008', 'type' => Order::TYPE_SALE, 'status' => Order::STATUS_COMPLETED]);

        $item->orders()->attach($purchaseOrder->id, ['quantity' => 10]); // Should not count
        $item->orders()->attach($saleOrder->id, ['quantity' => 5]); // Should count as -5

        $item->load('orders');

        $this->assertEquals(-5, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_purchase_orders()
    {
        $model = new Item;
        $item = $model->create(['name' => 'Item H', 'detail' => 'Detail H']);

        $model = new Order;
        $order1 = $model->create(['code' => 'ORD-001', 'type' => Order::TYPE_PURCHASE, 'status' => Order::STATUS_COMPLETED]);
        $order2 = $model->create(['code' => 'ORD-002', 'type' => Order::TYPE_PURCHASE, 'status' => Order::STATUS_COMPLETED]);

        $item->orders()->attach($order1->id, ['quantity' => 10]);
        $item->orders()->attach($order2->id, ['quantity' => 5]);

        $item->load('orders');

        $this->assertEquals(15, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_quantity_with_sale_orders()
    {
        $model = new Item;
        $item = $model->create(['name' => 'Item I', 'detail' => 'Detail I']);

        $model = new Order;
        $order1 = $model->create(['code' => 'ORD-003', 'type' => Order::TYPE_SALE, 'status' => Order::STATUS_COMPLETED]);
        $order2 = $model->create(['code' => 'ORD-004', 'type' => Order::TYPE_SALE, 'status' => Order::STATUS_COMPLETED]);

        $item->orders()->attach($order1->id, ['quantity' => 7]);
        $item->orders()->attach($order2->id, ['quantity' => 3]);

        $item->load('orders');

        $this->assertEquals(-10, $item->quantity);
    }

    /**
     * @return void
     */
    public function test_can_get_updated_at()
    {
        $model = new Item;

        $current = time();

        $item = $model->create(['name' => 'Item F', 'detail' => 'Detail F']);

        $date = date('d M Y h:i A', $current);

        $this->assertEquals($date, $item->updated_at);
    }
}
