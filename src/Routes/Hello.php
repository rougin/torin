<?php

namespace Rougin\Torin\Routes;

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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Plate $plate)
    {
        /** @var \Psr\Http\Message\ResponseInterface */
        return $plate->render('index');
    }
}
