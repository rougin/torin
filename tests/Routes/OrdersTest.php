<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\OrderDepot;
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
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $orderDepot;

    /**
     * @var \Rougin\Torin\Routes\Orders
     */
    protected $route;

    /**
     * @return void
     */
    public function test_can_change_order_status()
    {
        // Create a client and an item first for a valid order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Test Client for Status Change',
            'remarks' => 'Test Remarks',
            'type' => 1,
        ]);

        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Test Item for Status Change',
            'detail' => 'Test Detail',
        ]);

        $orderData = [
            'client_id' => $client->id,
            'type' => 1,
            'remarks' => 'Order for Status Change',
            'cart' => [
                ['id' => $item->id, 'quantity' => 1],
            ],
        ];
        $this->orderDepot->create($orderData);
        $orders = $this->orderDepot->get(1, 10)->items();
        $order = $orders[0]; // Get the created order

        $newStatus = \Rougin\Torin\Models\Order::STATUS_COMPLETED;

        // Simulate a PUT request
        $this->request = $this->request->withMethod('PUT');
        $this->request = $this->request->withParsedBody(['status' => $newStatus]);

        // Call the status method
        $response = $this->route->status($order->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify order status was updated in the database
        $updatedOrder = $this->orderDepot->find($order->id);
        $this->assertEquals($newStatus, $updatedOrder->status);
    }

    /**
     * @return void
     */
    public function test_can_check_cart_with_valid_data()
    {
        // Create an item first
        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Checkable Item',
            'detail' => 'Detail for check',
        ]);

        // Create a client for the purchase order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Client for Purchase',
            'remarks' => 'Remarks',
            'type' => 1,
        ]);

        // Create a purchase order to increase item quantity
        $orderDepot = new \Rougin\Torin\Depots\OrderDepot(new \Rougin\Torin\Models\Order);
        $orderDepot->create([
            'client_id' => $client->id,
            'type' => \Rougin\Torin\Models\Order::TYPE_PURCHASE,
            'remarks' => 'Purchase Order',
            'cart' => [
                ['id' => $item->id, 'quantity' => 10],
            ],
        ]);
        $purchaseOrder = $orderDepot->get(1, 10)->items()[0];
        $orderDepot->changeStatus($purchaseOrder->id, \Rougin\Torin\Models\Order::STATUS_COMPLETED);

        $cartData = [
            'item_id' => $item->id,
            'quantity' => 1,
            'type' => \Rougin\Torin\Models\Order::TYPE_SALE,
        ];

        // Simulate a POST request
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($cartData);

        // Call the check method
        $response = $this->route->check($itemDepot, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertTrue($data);
    }

    /**
     * @return void
     */
    public function test_can_create_order_with_store_method()
    {
        // Create a client and an item first for a valid order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Test Client for Order',
            'remarks' => 'Test Remarks',
            'type' => 1,
        ]);

        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Test Item for Order',
            'detail' => 'Test Detail',
        ]);

        $orderData = [
            'client_id' => $client->id,
            'type' => 1,
            'remarks' => 'New Order Remarks',
            'cart' => [
                ['id' => $item->id, 'quantity' => 5],
            ],
        ];

        // Simulate a POST request
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($orderData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        // Verify order was created in the database
        $result = $this->orderDepot->get(1, 10);
        $orders = $result->items();
        $this->assertCount(1, $orders);
        $this->assertEquals('New Order Remarks', $orders[0]->remarks);
        $this->assertEquals($client->id, $orders[0]->client_id);
        $this->assertEquals(1, $orders[0]->type);
    }

    /**
     * @return void
     */
    public function test_can_delete_order_with_delete_method()
    {
        // Create a client and an item first for a valid order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Test Client for Delete Order',
            'remarks' => 'Test Remarks',
            'type' => 1,
        ]);

        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Test Item for Delete Order',
            'detail' => 'Test Detail',
        ]);

        $orderData = [
            'client_id' => $client->id,
            'type' => 1,
            'remarks' => 'Order to Delete Remarks',
            'cart' => [
                ['id' => $item->id, 'quantity' => 1],
            ],
        ];
        $this->orderDepot->create($orderData);
        $orders = $this->orderDepot->get(1, 10)->items();
        $order = $orders[0]; // Get the created order

        // Simulate a DELETE request
        $this->request = $this->request->withMethod('DELETE');

        // Call the delete method
        $response = $this->route->delete($order->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify order was deleted from the database
        $this->assertFalse($this->orderDepot->rowExists($order->id));
    }

    /**
     * @return void
     */
    public function test_can_get_all_orders_with_index_method()
    {
        // Create some order data using the depot directly
        // Note: OrderDepot::create requires client_id, type, and cart
        // We need to create a client and an item first for a valid order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Test Client',
            'remarks' => 'Test Remarks',
            'type' => 1,
        ]);

        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Test Item',
            'detail' => 'Test Detail',
        ]);

        $this->orderDepot->create([
            'client_id' => $client->id,
            'type' => 1,
            'remarks' => 'Order 1 Remarks',
            'cart' => [
                ['id' => $item->id, 'quantity' => 1],
            ],
        ]);

        $this->orderDepot->create([
            'client_id' => $client->id,
            'type' => 2,
            'remarks' => 'Order 2 Remarks',
            'cart' => [
                ['id' => $item->id, 'quantity' => 2],
            ],
        ]);

        // Simulate a GET request and call the index method
        $response = $this->route->index($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data['items']);
        $this->assertEquals('Order 1 Remarks', $data['items'][0]['remarks']);
        $this->assertEquals('Order 2 Remarks', $data['items'][1]['remarks']);
    }

    /**
     * @return void
     */
    public function test_cannot_check_cart_with_invalid_data()
    {
        // Create an item first
        $itemDepot = new \Rougin\Torin\Depots\ItemDepot(new \Rougin\Torin\Models\Item);
        $item = $itemDepot->create([
            'name' => 'Checkable Item',
            'detail' => 'Detail for check',
        ]);

        // Scenario 1: Non-existent item ID
        $cartData1 = [
            'item_id' => 999, // Non-existent item
            'quantity' => 1,
            'type' => \Rougin\Torin\Models\Order::TYPE_SALE,
        ];

        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($cartData1);
        $response = $this->route->check($itemDepot, $this->request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode());
        $data = json_decode((string) $response->getBody(), true);
        $this->assertEquals('Item not found', $data);

        // Scenario 2: Insufficient quantity for sale
        // Create a client for the purchase order
        $clientDepot = new \Rougin\Torin\Depots\ClientDepot(new \Rougin\Torin\Models\Client);
        $client = $clientDepot->create([
            'name' => 'Client for Purchase',
            'remarks' => 'Remarks',
            'type' => 1,
        ]);

        // Create a purchase order with quantity 1
        $orderDepot = new \Rougin\Torin\Depots\OrderDepot(new \Rougin\Torin\Models\Order);
        $orderDepot->create([
            'client_id' => $client->id,
            'type' => \Rougin\Torin\Models\Order::TYPE_PURCHASE,
            'remarks' => 'Purchase Order',
            'cart' => [
                ['id' => $item->id, 'quantity' => 1],
            ],
        ]);
        $purchaseOrder = $orderDepot->get(1, 10)->items()[0];
        $orderDepot->changeStatus($purchaseOrder->id, \Rougin\Torin\Models\Order::STATUS_COMPLETED);

        $cartData2 = [
            'item_id' => $item->id,
            'quantity' => 10, // Insufficient quantity (only 1 available from purchase)
            'type' => \Rougin\Torin\Models\Order::TYPE_SALE,
        ];

        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($cartData2);
        $response = $this->route->check($itemDepot, $this->request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode());
        $data = json_decode((string) $response->getBody(), true);
        $this->assertEquals('Not enough quantity', $data);
    }

    /**
     * @return void
     */
    public function test_cannot_create_order_with_invalid_data()
    {
        $invalidOrderData = [
            // Missing 'cart', 'client_id', and 'type'
            'remarks' => 'Invalid Order Remarks',
        ];

        // Simulate a POST request with invalid data
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($invalidOrderData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('cart', $data);
        $this->assertArrayHasKey('client_id', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertEquals('Cart is required', $data['cart'][0]);
        $this->assertEquals('Client Name is required', $data['client_id'][0]);
        $this->assertEquals('Order Type is required', $data['type'][0]);

        // Verify no order was created in the database
        $result = $this->orderDepot->get(1, 10);
        $orders = $result->items();
        $this->assertCount(0, $orders);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->withHttp();

        $check = new OrderCheck;

        $this->orderDepot = new OrderDepot(new Order);

        $this->route = new Orders($check, $this->orderDepot);
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
