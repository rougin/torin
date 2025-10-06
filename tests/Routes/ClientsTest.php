<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\JsonResponse;
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
    protected $clientDepot;

    /**
     * @var \Rougin\Torin\Routes\Clients
     */
    protected $route;

    /**
     * @return void
     */
    public function test_can_create_client_with_store_method()
    {
        $clientData = [
            'name' => 'New Client',
            'remarks' => 'New Remarks',
            'type' => 3,
        ];

        // Simulate a POST request
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($clientData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        // Verify client was created in the database
        $clients = $this->clientDepot->all();
        $this->assertCount(1, $clients);
        $this->assertEquals('New Client', $clients[0]->name);
    }

    /**
     * @return void
     */
    public function test_can_delete_client_with_delete_method()
    {
        // Create a client first
        $initialClientData = [
            'name' => 'Client to Delete',
            'remarks' => 'Remarks for deletion',
            'type' => 1,
        ];
        $this->clientDepot->create($initialClientData);
        $client = $this->clientDepot->all()->first(); // Get the created client

        // Simulate a DELETE request
        $this->request = $this->request->withMethod('DELETE');

        // Call the delete method
        $response = $this->route->delete($client->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify client was deleted from the database
        $this->assertFalse($this->clientDepot->rowExists($client->id));
    }

    /**
     * @return void
     */
    public function test_can_get_all_clients_with_index_method()
    {
        // Create some client data using the depot directly
        $this->clientDepot->create([
            'name' => 'Test Client 1',
            'remarks' => 'Remarks 1',
            'type' => 1,
        ]);

        $this->clientDepot->create([
            'name' => 'Test Client 2',
            'remarks' => 'Remarks 2',
            'type' => 2,
        ]);

        // Simulate a GET request and call the index method
        $response = $this->route->index($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertCount(2, $data['items']);
        $this->assertEquals('Test Client 1', $data['items'][0]['name']);
        $this->assertEquals('Test Client 2', $data['items'][1]['name']);
    }

    /**
     * @return void
     */
    public function test_can_get_clients_for_select_method()
    {
        // Create some clients
        $this->clientDepot->create([
            'name' => 'Select Client A',
            'remarks' => 'Remarks A',
            'type' => 1,
        ]);
        $this->clientDepot->create([
            'name' => 'Select Client B',
            'remarks' => 'Remarks B',
            'type' => 2,
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
        $this->assertEquals('Select Client A', $data[0]['label']);
        $this->assertEquals(2, $data[1]['value']);
        $this->assertEquals('Select Client B', $data[1]['label']);
    }

    /**
     * @return void
     */
    public function test_can_update_client_with_update_method()
    {
        // Create a client first
        $initialClientData = [
            'name' => 'Original Client',
            'remarks' => 'Original Remarks',
            'type' => 1,
        ];
        $this->clientDepot->create($initialClientData);
        $client = $this->clientDepot->all()->first(); // Get the created client

        $updatedClientData = [
            'name' => 'Updated Client',
            'remarks' => 'Updated Remarks',
            'type' => 2,
        ];

        // Simulate a PUT request
        $this->request = $this->request->withMethod('PUT');
        $this->request = $this->request->withParsedBody($updatedClientData);

        // Call the update method
        $response = $this->route->update($client->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode()); // No Content

        // Verify client was updated in the database
        $updatedClient = $this->clientDepot->find($client->id);
        $this->assertEquals('Updated Client', $updatedClient->name);
        $this->assertEquals('Updated Remarks', $updatedClient->remarks);
        $this->assertEquals(2, $updatedClient->type);
    }

    /**
     * @return void
     */
    public function test_cannot_create_client_with_invalid_data()
    {
        $invalidClientData = [
            'remarks' => 'Invalid Remarks', // Missing 'name' and 'type'
        ];

        // Simulate a POST request with invalid data
        $this->request = $this->request->withMethod('POST');
        $this->request = $this->request->withParsedBody($invalidClientData);

        // Call the store method
        $response = $this->route->store($this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertEquals('Client Name is required', $data['name'][0]);
        $this->assertEquals('Client Type is required', $data['type'][0]);

        // Verify no client was created in the database
        $clients = $this->clientDepot->all();
        $this->assertCount(0, $clients);
    }

    /**
     * @return void
     */
    public function test_cannot_delete_non_existent_client()
    {
        $nonExistentClientId = 999; // An ID that surely does not exist

        // Simulate a DELETE request
        $this->request = $this->request->withMethod('DELETE');

        // Call the delete method
        $response = $this->route->delete($nonExistentClientId, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertEquals([], $data); // Expecting an empty array for errors
    }

    /**
     * @return void
     */
    public function test_cannot_update_client_with_invalid_data()
    {
        // Create a client first
        $initialClientData = [
            'name' => 'Original Client',
            'remarks' => 'Original Remarks',
            'type' => 1,
        ];
        $this->clientDepot->create($initialClientData);
        $client = $this->clientDepot->all()->first(); // Get the created client

        $invalidUpdatedClientData = [
            'remarks' => 'Updated Remarks', // Missing 'name' and 'type'
        ];

        // Simulate a PUT request with invalid data
        $this->request = $this->request->withMethod('PUT');
        $this->request = $this->request->withParsedBody($invalidUpdatedClientData);

        // Call the update method
        $response = $this->route->update($client->id, $this->request);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode()); // Unprocessable Entity

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertEquals('Client Name is required', $data['name'][0]);
        $this->assertEquals('Client Type is required', $data['type'][0]);

        // Verify client was NOT updated in the database
        $unchangedClient = $this->clientDepot->find($client->id);
        $this->assertEquals('Original Client', $unchangedClient->name);
        $this->assertEquals('Original Remarks', $unchangedClient->remarks);
        $this->assertEquals(1, $unchangedClient->type);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->withHttp(); // This sets REQUEST_METHOD to 'GET' by default

        $check = new ClientCheck;

        $this->clientDepot = new ClientDepot(new Client);

        $this->route = new Clients($check, $this->clientDepot);
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
