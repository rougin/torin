<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexter\Alpine\Depot;
use Rougin\Gable\Pagee;
use Rougin\Gable\Table;
use Rougin\Temply\Plate;
use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items
{
    /**
     * @param \Rougin\Torin\Depots\ItemDepot           $item
     * @param \Rougin\Temply\Plate                     $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return string
     */
    public function index(ItemDepot $item, Plate $plate, ServerRequestInterface $request)
    {
        $data = array('depot' => new Depot('items'));

        // Prepare the pagination --------------------------
        $pagee = Pagee::fromRequest($request)->asAlpine();

        $link = $plate->getLinkHelper()->set('items');

        $pagee->setLink($link)->setTotal($item->getTotal());

        $data['pagee'] = $pagee;
        // -------------------------------------------------

        // Generate the HTML table -----------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Item Code', 'left')->withWidth(10)->withName('code');
        $table->setCell('Name', 'left')->withWidth(15);
        $table->setCell('Description', 'left')->withWidth(15)->withName('detail');
        $table->setCell('Created At', 'left')->withWidth(12);
        $table->setCell('Updated At', 'left')->withWidth(12);
        $table->withActions(null, 'left')->withWidth(5);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading($pagee->getLimit());
        $table->withAlpine();
        $table->withOpacity(50);

        $data['table'] = $table;
        // -----------------------------------------------------------------------

        return $plate->render('items.index', $data);
    }
}
