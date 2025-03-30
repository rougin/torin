<?php

namespace Rougin\Torin\Checks;

use Rougin\Valdi\Request;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $labels =
    [
        'client_id' => 'Client Name',
        'cart' => 'Cart',
        'remarks' => 'Remarks',
        'type' => 'Order Type',
    ];

    /**
     * @var array<string, string>
     */
    protected $rules =
    [
        'cart' => 'required',
        'client_id' => 'required',
        'type' => 'required',
    ];
}
