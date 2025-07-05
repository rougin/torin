<?php

namespace Rougin\Torin\Pages;

use Rougin\Dexal\Depot;
use Rougin\Gable\Table;
use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items extends Page
{
    /**
     * @param \Rougin\Torin\Depots\ItemDepot $item
     *
     * @return string
     */
    public function index(ItemDepot $item)
    {
        $data = array('depot' => new Depot('items'));

        // Prepare the pagination -------------
        $total = $item->getTotal();

        $pagee = $this->pagee('items', $total);

        $data['pagee'] = $pagee;
        // ------------------------------------

        // Generate the HTML table -----------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Item Code', 'left')->withWidth(10)->withName('code');
        $table->setCell('Name', 'left')->withWidth(15);
        $table->setCell('Description', 'left')->withWidth(15)->withName('detail');
        $table->setCell('Quantity', 'right')->withWidth(5);
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

        return $this->render('items.index', $data);
    }
}
