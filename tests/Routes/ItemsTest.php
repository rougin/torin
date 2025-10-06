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
    protected $itemDepot;

    /**
     * @var \Rougin\Torin\Routes\Items
     */
    protected $route;

    /**
     * @return void
     */
    public function test_can_create_item_with_store_method()
    {
        $itemData = [
            'name' => 'New Item',
            'detail' => 'New Detail',
        ];

        // Simulate a POST request
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($itemData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        // Verify item was created in the database
        $items = $this->itemDepot->all();
        $this->assertCount(1, $items);
        $this->assertEquals('New Item', $items[0]->name);
    }

    /**
     * @return void
     */
    public function test_can_delete_item_with_delete_method()
    {
        // Create an item first
        $initialItemData = [
            'name' => 'Item to Delete',
            'detail' => 'Detail for deletion',
        ];
        $this->itemDepot->create($initialItemData);
        $item = $this->itemDepot->all()->first(); // Get the created item

        // Simulate a DELETE request
        $this->request = $this->request->withMethod('DELETE');

        // Call the delete method
        $response = $this->route->delete($item->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify item was deleted from the database
        $this->assertFalse($this->itemDepot->rowExists($item->id));
    }

    /**
     * @return void
     */
    public function test_can_filter_items_by_keyword()
    {
        // Create some items
        $this->itemDepot->create([
            'name' => 'Apple',
            'detail' => 'Fruit',
        ]);
        $this->itemDepot->create([
            'name' => 'Banana',
            'detail' => 'Fruit',
        ]);
        $this->itemDepot->create([
            'name' => 'Orange',
            'detail' => 'Fruit',
        ]);
        $this->itemDepot->create([
            'name' => 'Pineapple',
            'detail' => 'Fruit',
        ]);

        // Simulate a GET request with a keyword filter
        $this->request = $this->request->withQueryParams(['k' => 'app']);

        // Call the index method
        $response = $this->route->index($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data['items']);
        $this->assertEquals('Apple', $data['items'][0]['name']);
        $this->assertEquals('Pineapple', $data['items'][1]['name']);
    }

    /**
     * @return void
     */
    public function test_can_get_all_items_with_index_method()
    {
        // Create some item data using the depot directly
        $this->itemDepot->create([
            'name' => 'Test Item 1',
            'detail' => 'Detail 1',
        ]);

        $this->itemDepot->create([
            'name' => 'Test Item 2',
            'detail' => 'Detail 2',
        ]);

        // Simulate a GET request and call the index method
        $response = $this->route->index($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data['items']);
        $this->assertEquals('Test Item 1', $data['items'][0]['name']);
        $this->assertEquals('Test Item 2', $data['items'][1]['name']);
    }

    /**
     * @return void
     */
    public function test_can_get_items_for_select_method()
    {
        // Create some items
        $this->itemDepot->create([
            'name' => 'Select Item A',
            'detail' => 'Detail A',
        ]);
        $this->itemDepot->create([
            'name' => 'Select Item B',
            'detail' => 'Detail B',
        ]);

        // Call the select method
        $response = $this->route->select();

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data);
        $this->assertArrayHasKey('value', $data[0]);
        $this->assertArrayHasKey('label', $data[0]);
        $this->assertEquals(1, $data[0]['value']);
        $this->assertEquals('Select Item A', $data[0]['label']);
        $this->assertEquals(2, $data[1]['value']);
        $this->assertEquals('Select Item B', $data[1]['label']);
    }

    /**
     * @return void
     */
    public function test_can_update_item_with_update_method()
    {
        // Create an item first
        $initialItemData = [
            'name' => 'Original Item',
            'detail' => 'Original Detail',
        ];
        $this->itemDepot->create($initialItemData);
        $item = $this->itemDepot->all()->first(); // Get the created item

        $updatedItemData = [
            'name' => 'Updated Item',
            'detail' => 'Updated Detail',
        ];

        // Simulate a PUT request
        $this->request = $this->request->withMethod('PUT');
        $this->request = $this->request->withParsedBody($updatedItemData);

        // Call the update method
        $response = $this->route->update($item->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify item was updated in the database
        $updatedItem = $this->itemDepot->find($item->id);
        $this->assertEquals('Updated Item', $updatedItem->name);
        $this->assertEquals('Updated Detail', $updatedItem->detail);
    }

    /**
     * @return void
     */
    public function test_cannot_create_item_with_invalid_data()
    {
        $invalidItemData = [
            // Missing 'name' and 'detail'
        ];

        // Simulate a POST request with invalid data
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($invalidItemData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('detail', $data);
        $this->assertEquals('Name is required', $data['name'][0]);
        $this->assertEquals('Description is required', $data['detail'][0]);

        // Verify no item was created in the database
        $items = $this->itemDepot->all();
        $this->assertCount(0, $items);
    }

    /**
     * @return void
     */
    public function test_cannot_delete_non_existent_item()
    {
        $nonExistentItemId = 999; // An ID that surely does not exist

        // Simulate a DELETE request
        $this->request = $this->request->withMethod('DELETE');

        // Call the delete method
        $response = $this->route->delete($nonExistentItemId, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertEquals([], $data); // Expecting an empty array for errors
    }

    /**
     * @return void
     */
    public function test_cannot_update_item_with_invalid_data()
    {
        // Create an item first
        $initialItemData = [
            'name' => 'Original Item',
            'detail' => 'Original Detail',
        ];
        $this->itemDepot->create($initialItemData);
        $item = $this->itemDepot->all()->first(); // Get the created item

        $invalidUpdatedItemData = [
            // Missing 'name' and 'detail'
        ];

        // Simulate a PUT request with invalid data
        $this->request = $this->request->withMethod('PUT');
        $this->request = $this->request->withParsedBody($invalidUpdatedItemData);

        // Call the update method
        $response = $this->route->update($item->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('detail', $data);
        $this->assertEquals('Name is required', $data['name'][0]);
        $this->assertEquals('Description is required', $data['detail'][0]);

        // Verify item was NOT updated in the database
        $unchangedItem = $this->itemDepot->find($item->id);
        $this->assertEquals('Original Item', $unchangedItem->name);
        $this->assertEquals('Original Detail', $unchangedItem->detail);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->withHttp();

        $check = new ItemCheck;

        $this->itemDepot = new ItemDepot(new Item);

        $this->route = new Items($check, $this->itemDepot);
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
