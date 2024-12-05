<?php

namespace Rougin\Torin;

use Rougin\Onion\BodyParams;
use Rougin\Onion\CorsHeader;
use Rougin\Onion\FormParser;
use Rougin\Onion\NullString;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Kernel
{
    /**
     * Returns a listing of global HTTP middlewares.
     *
     * @return \Rougin\Slytherin\Middleware\MiddlewareInterface[]
     */
    public static function items()
    {
        $items = array();

        $items[] = new BodyParams;
        $items[] = new FormParser;
        $items[] = new NullString;
        $items[] = new CorsHeader;

        return $items;
    }
}
