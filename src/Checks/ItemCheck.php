<?php

namespace Rougin\Torin\Checks;

use Rougin\Valla\Request;

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
    protected $labels = array(

        'name' => 'Name',
        'detail' => 'Description',

    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'name' => 'required',
        'detail' => 'required',

    );
}
