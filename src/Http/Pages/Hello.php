<?php

namespace Rougin\Torin\Http\Pages;

use Rougin\Temply\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Hello
{
    /**
     * @param \Rougin\Temply\Plate $plate
     *
     * @return string
     */
    public function index(Plate $plate)
    {
        return $plate->render('index');
    }
}
