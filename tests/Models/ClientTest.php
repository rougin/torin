<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientTest extends Testcase
{
    public function setUp(): void
    {
        parent::setUp();

        // Define schema directly for testing
        Capsule::schema('torin')->create('clients', function ($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function tearDown(): void
    {
        Capsule::schema('torin')->drop('clients');
        parent::tearDown();
    }

    public function testCanCreateClient(): void
    {
        /** @var \Rougin\Torin\Models\Client $client */
        $client = Client::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ]);

        $this->assertNotNull($client->id);
        $this->assertEquals('John Doe', $client->name);
    }

    public function testCanFindClient(): void
    {
        Client::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com'
        ]);

        /** @var \Rougin\Torin\Models\Client|null $client */
        $client = Client::where('email', 'jane.doe@example.com')->first();

        $this->assertNotNull($client);
        $this->assertEquals('Jane Doe', $client->name);
    }
}
