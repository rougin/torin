<?php

namespace Rougin\Torin\Routes;

use Rougin\Torin\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Hello
{
    /**
     * @param \Rougin\Torin\Plate $plate
     *
     * @return string
     */
    public function page(Plate $plate)
    {
        return $plate->render('index');
    }
}
