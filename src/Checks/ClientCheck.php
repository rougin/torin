<?php

namespace Rougin\Torin\Checks;

use Rougin\Validia\Request;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $labels = array(

        'name' => 'Client Name',
        'remarks' => 'Remarks',
        'type' => 'Client Type',

    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'name' => 'required',
        'type' => 'required',

    );
}
