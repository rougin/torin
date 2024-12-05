<?php

namespace Rougin\Torin\Routes;

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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Plate $plate)
    {
        $items = array();

        $item = array('code' => 'XXX-123');
        $item['name'] = 'Hello world';
        $item['detail'] = 'A sample item';
        $items[] = $item;

        $item = array('code' => 'YYY-456');
        $item['name'] = 'World of hello';
        $item['detail'] = 'Another item';
        $items[] = $item;

        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Code', 'left')->withWidth(1);
        $table->setCell('Name', 'left')->withWidth(5);
        $table->setCell('Description', 'left')->withWidth(10)->withName('detail');
        $table->setCell('Action', 'left')->withWidth(1);
        $table->setData($items);

        $data = compact('table');

        /** @var \Psr\Http\Message\ResponseInterface */
        return $plate->render('items.index', $data);
    }
}
