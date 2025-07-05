<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexal\Depot;
use Rougin\Fortem\Plate;
use Rougin\Gable\Pagee;
use Rougin\Gable\Table;
use Rougin\Torin\Depots\ClientDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Clients
{
    /**
     * @param \Rougin\Torin\Depots\ClientDepot         $client
     * @param \Rougin\Fortem\Plate                     $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return string
     */
    public function index(ClientDepot $client, Plate $plate, ServerRequestInterface $request)
    {
        $data = array('depot' => new Depot('clients'));

        // Prepare the pagination ----------------------------
        $pagee = Pagee::fromRequest($request)->asAlpine();

        $link = $plate->getLinkHelper()->set('clients');

        $pagee->setLink($link)->setTotal($client->getTotal());

        $data['pagee'] = $pagee;
        // ---------------------------------------------------

        // Generate the HTML table ----------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');
        $table->newColumn();

        $table->setCell('Type', 'left')
            ->addBadge('Customer', 'item.type === 0', 'text-bg-success')
            ->addBadge('Supplier', 'item.type === 1', 'text-bg-primary')
            ->withWidth(5);
        $table->setCell('Client Name', 'left')
            ->addHtml('<p class="mb-0" x-text="item.name"></p>')
            ->addHtml('<p class="mb-0 small text-muted" x-text="item.code"></p>')
            ->withWidth(22);
        $table->setCell('Remarks', 'left')
            ->addHtml('<p class="mb-0 fst-italic" x-text="item.remarks"></p>')
            ->withWidth(15);
        $table->setCell('Created At', 'left')->withWidth(13);
        $table->setCell('Updated At', 'left')->withWidth(13);
        $table->withActions(null, 'left')->withWidth(5);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading($pagee->getLimit());
        $table->withNoItemsText('No clients found.');
        $table->withLoadErrorText('An error occured in getting the clients.');
        $table->withAlpine();
        $table->withOpacity(50);

        $data['table'] = $table;
        // ----------------------------------------------------------------------

        return $plate->render('clients.index', $data);
    }
}
