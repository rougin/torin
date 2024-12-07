<?php

namespace Rougin\Torin\Pages;

use Rougin\Gable\Table;
use Rougin\Temply\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items
{
    /**
     * @param \Rougin\Temply\Plate $plate
     *
     * @return string
     */
    public function index(Plate $plate)
    {
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Code', 'left')->withWidth(1);
        $table->setCell('Name', 'left')->withWidth(5);
        $table->setCell('Description', 'left')->withWidth(10)->withName('detail');
        $table->setCell('Action', 'left')->withWidth(1);
        $table->withAlpine();

        $data = array('table' => $table);

        return $plate->render('items.index', $data);
    }
}
