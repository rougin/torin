<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexter\Alpine\Depot;
use Rougin\Gable\Pagee;
use Rougin\Gable\Table;
use Rougin\Temply\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders
{
    /**
     * @param \Rougin\Temply\Plate $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return string
     */
    public function index(Plate $plate, ServerRequestInterface $request)
    {
        // Prepare the pagination ------------------------------
        $pagee = (new Pagee)->asAlpine();

        $pagee->fromRequest($request);

        $pagee->setLink($plate->getLinkHelper()->set('orders'));
        // -----------------------------------------------------

        // Generate the HTML table ------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Type', 'left');
        $table->addBadge('Purchase', 'item.type === 1', 'text-bg-primary');
        $table->addBadge('Sales', 'item.type === 0', 'text-bg-success');
        $table->addBadge('Transfer', 'item.type === 2', 'text-bg-secondary');
        $table->setCell('Status', 'left');
        $table->addBadge('Cancelled', 'item.type === 2', 'text-bg-danger');
        $table->addBadge('Fulfilled', 'item.type === 1', 'text-bg-success');
        $table->addBadge('Pending', 'item.type === 0', 'text-bg-warning');
        $table->setCell('Order Code', 'left')->withName('code');
        $table->setCell('Name', 'left');
        $table->setCell('Description', 'left')->withName('detail');
        $table->setCell('Created At', 'left')->withName('created_at');
        $table->setCell('Updated At', 'left')->withName('updated_at');
        $table->withActions(null, 'left');
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading();
        $table->withNoItemsText('No orders found.');
        $table->withLoadErrorText('An error occured in getting the orders.');
        $table->withAlpine();
        $table->withOpacity(50);
        // ------------------------------------------------------------------

        $depot = new Depot('orders');

        $data = compact('depot', 'pagee', 'table');

        return $plate->render('orders.index', $data);
    }
}
