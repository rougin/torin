<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientTest extends Testcase
{
    /**
     * @return void
     */
    public function test_can_create_a_client()
    {
        $model = new Client;

        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $actual = $model->create($data)->name;

        $this->assertEquals('John Doe', $actual);
    }

    /**
     * @return void
     */
    public function test_can_find_a_client()
    {
        $model = new Client;

        $data = array('name' => 'Jane Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $model->create($data);

        $model = $model->where('name', 'Jane Doe');
        $actual = $model->firstOrFail()->name;

        $this->assertEquals('Jane Doe', $actual);
    }
}
