<?php

namespace Rougin\Torin\Depots;

use Rougin\Torin\Testcase;
use Rougin\Torin\Models\Client;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientDepotTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $depot;

    public function setUp(): void
    {
        parent::setUp();

        Capsule::schema('torin')->create('clients', function ($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->depot = new ClientDepot(new Client);
    }

    public function tearDown(): void
    {
        Capsule::schema('torin')->drop('clients');
        parent::tearDown();
    }

    public function testCanFindAllClients(): void
    {
        Client::create(['name' => 'Client A', 'email' => 'a@example.com']);
        Client::create(['name' => 'Client B', 'email' => 'b@example.com']);

        /** @var \Rougin\Torin\Models\Client[] $clients */
        $clients = $this->depot->all();

        $this->assertCount(2, $clients);
        $this->assertEquals('Client A', $clients[0]->name);
    }

    public function testCanFindClientById(): void
    {
        /** @var \Rougin\Torin\Models\Client $createdClient */
        $createdClient = Client::create(['name' => 'Client C', 'email' => 'c@example.com']);

        /** @var \Rougin\Torin\Models\Client|null $foundClient */
        $foundClient = $this->depot->find($createdClient->id);

        $this->assertNotNull($foundClient);
        $this->assertEquals('Client C', $foundClient->name);
    }
}
