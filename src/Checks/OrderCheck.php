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
    protected $labels = array();

    /**
     * @var array<string, string>
     */
    protected $rules = array();
}
