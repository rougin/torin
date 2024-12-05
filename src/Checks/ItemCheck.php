<?php

namespace Rougin\Torin\Checks;

use Rougin\Valdi\Request;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $labels =
    [
        'name' => 'Name',
        'detail' => 'Description',
    ];

    /**
     * @var array<string, string>
     */
    protected $rules =
    [
        'name' => 'required',
        'detail' => 'required',
    ];
}
