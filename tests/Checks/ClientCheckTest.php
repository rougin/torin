<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Models\Client;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientCheckTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Checks\ClientCheck
     */
    protected $check;

    /**
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $item = array();
        $item[] = array('type' => Client::TYPE_CUSTOMER);
        $item[] = 'Client Name is required';
        $items[] = $item;

        $item = array();
        $item[] = array('name' => 'John Doe');
        $item[] = 'Client Type is required';
        $items[] = $item;

        return $items;
    }

    /**
     * @dataProvider for_errors_provider
     *
     * @param array<string, string> $data
     * @param string                $text
     *
     * @return void
     */
    public function test_for_errors($data, $text)
    {
        $actual = $this->check->valid($data);

        $this->assertFalse($actual);

        $actual = $this->check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed_check()
    {
        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_CUSTOMER;

        $actual = $this->check->valid($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->check = new ClientCheck;
    }
}
