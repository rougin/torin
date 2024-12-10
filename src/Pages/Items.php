<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Gable\Pagee;
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
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return string
     */
    public function index(Plate $plate, ServerRequestInterface $request)
    {
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Code', 'left')->withWidth(27);
        $table->setCell('Name', 'left')->withWidth(20);
        $table->setCell('Description', 'left')->withWidth(35)->withName('detail');
        $table->withActions(null, 'left')->withWidth(10);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading();
        $table->withAlpine();

        /** @var array<string, mixed> */
        $params = $request->getQueryParams();

        $data = array('table' => $table);

        $limit = $params['l'] ?? 10;

        $page = $params['q'] ?? 1;

        $data['pagee'] = new Pagee($page, $limit);

        return $plate->render('items.index', $data);
    }
}
