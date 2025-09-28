<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Models\Order;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderCheckTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Checks\OrderCheck
     */
    protected $check;

    /**
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $item = array();
        $item[] = array('client_id' => 1, 'type' => Order::TYPE_SALE);
        $item[] = 'Cart is required';
        $items[] = $item;

        $item = array();
        $item[] = array('cart' => array(), 'type' => Order::TYPE_SALE);
        $item[] = 'Client Name is required';
        $items[] = $item;

        $item = array();
        $item[] = array('cart' => array(), 'client_id' => 1);
        $item[] = 'Order Type is required';
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
        $data = array('client_id' => 1);
        $data['type'] = Order::TYPE_SALE;

        $cart = array('id' => 1);
        $cart['quantity'] = 20;
        $data['cart'] = array($cart);

        $actual = $this->check->valid($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->check = new OrderCheck;
    }
}
