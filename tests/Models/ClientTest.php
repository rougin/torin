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
    public function test_should_create_a_client()
    {
        $model = new Client;

        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $actual = $model->create($data)->name;

        $expect = 'John Doe';
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_should_find_a_client()
    {
        $model = new Client;

        $data = array('name' => 'Jane Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $model->create($data);

        $model = $model->where('name', 'Jane Doe');
        $actual = $model->firstOrFail()->name;

        $expect = 'Jane Doe';
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
