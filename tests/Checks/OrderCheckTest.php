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

        $data = array('client_id' => 1);
        $data['type'] = Order::TYPE_SALE;
        $item = array($data);
        $item[] = 'Cart is required';
        $items[] = $item;

        $data = array('cart' => array());
        $data['type'] = Order::TYPE_SALE;
        $item[] = 'Client Name is required';
        $items[] = $item;

        $data = array('cart' => array());
        $data['client_id'] = 100;
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
        $check = new OrderCheck;

        $this->assertFalse($check->valid($data));

        $actual = $check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed()
    {
        $data = array('client_id' => 1);
        $data['type'] = Order::TYPE_SALE;

        $cart = array('id' => 1);
        $cart['quantity'] = 20;
        $data['cart'] = array($cart);

        $check = new OrderCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
