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
        // Prepare the pagination -----------------------------
        $pagee = (new Pagee)->asAlpine();

        $pagee->fromRequest($request);

        $pagee->setLink($plate->getLinkHelper()->set('items'));

        $pagee->setTotal($item->getTotal());
        // ----------------------------------------------------

        // Generate the HTML table --------------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Item Code', 'left')->withWidth(10)->withName('code');
        $table->setCell('Name', 'left')->withWidth(15);
        $table->setCell('Description', 'left')->withWidth(15)->withName('detail');
        $table->setCell('Created At', 'left')->withWidth(12)->withName('created_at');
        $table->setCell('Updated At', 'left')->withWidth(12)->withName('updated_at');
        $table->withActions(null, 'left')->withWidth(5);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading($pagee->getLimit());
        $table->withAlpine();
        $table->withOpacity(50);
        // --------------------------------------------------------------------------

        $depot = new Depot('items');

        $data = compact('depot', 'pagee', 'table');

        return $plate->render('items.index', $data);
    }
}
