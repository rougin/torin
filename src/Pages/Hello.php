<?php

namespace Rougin\Torin\Pages;

use Rougin\Fortem\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Hello
{
    /**
     * @param \Rougin\Fortem\Plate $plate
     *
     * @return string
     */
    public function index(Plate $plate)
    {
        return $plate->render('index');
    }
}
