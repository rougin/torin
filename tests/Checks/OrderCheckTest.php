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
     * @return void
     */
    public function test_failed_if_field_is_required()
    {
        $data = array('client_id' => 1);

        $data['type'] = Order::TYPE_SALE;

        $expect = 'Cart is required';

        $check = new OrderCheck;

        $actual = $check->valid($data);

        $this->assertFalse($actual);

        $actual = $check->firstError();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_valid_data()
    {
        // Initialize required data -----
        $data = array('client_id' => 1);

        $data['type'] = Order::TYPE_SALE;
        // ------------------------------

        // Prepare items in cart ----
        $cart = array('id' => 1);

        $cart['quantity'] = 20;

        $data['cart'] = array($cart);
        // --------------------------

        $check = new OrderCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
