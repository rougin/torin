<?php

    namespace Rougin\Torin\Models;

    use Rougin\Torin\Testcase;
    use Rougin\Torin\Models\Client;
    use Illuminate\Database\Capsule\Manager as Capsule;

    class ClientTest extends Testcase
    {
        public function setUp(): void
        {
            parent::setUp();

            // Define schema directly for testing
            Capsule::schema('torin')->create('clients', function ($table) {
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

        public function testCanCreateClient()
        {
            $client = Client::create([
                'name' => 'John Doe',
                'email' => 'john.doe@example.com'
            ]);

            $this->assertNotNull($client->id);
            $this->assertEquals('John Doe', $client->name);
        }

        public function testCanFindClient()
        {
            Client::create([
                'name' => 'Jane Doe',
                'email' => 'jane.doe@example.com'
            ]);

            $client = Client::where('email', 'jane.doe@example.com')->first();

            $this->assertNotNull($client);
            $this->assertEquals('Jane Doe', $client->name);
        }
    }