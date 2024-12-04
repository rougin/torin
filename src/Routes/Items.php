<?php

namespace Rougin\Torin\Routes;

use Rougin\Torin\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items
{
    /**
     * @param \Rougin\Torin\Plate $plate
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Plate $plate)
    {
        return $plate->render('items.index');
    }
}
