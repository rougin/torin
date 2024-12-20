<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexter\Alpine\Depot;
use Rougin\Gable\Pagee;
use Rougin\Gable\Table;
use Rougin\Temply\Plate;
use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders
{
    /**
     * @param \Rougin\Torin\Depots\OrderDepot $order
     * @param \Rougin\Temply\Plate $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return string
     */
    public function index(OrderDepot $order, Plate $plate, ServerRequestInterface $request)
    {
        $data = array('depot' => new Depot('orders'));

        // Prepare the pagination ---------------------------
        $pagee = Pagee::fromRequest($request)->asAlpine();

        $link = $plate->getLinkHelper()->set('orders');

        $pagee->setLink($link)->setTotal($order->getTotal());

        $data['pagee'] = $pagee;
        // --------------------------------------------------

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
        $table->setCell('Created At', 'left');
        $table->setCell('Updated At', 'left');
        $table->withActions(null, 'left');
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');
        $table->withLoading();
        $table->withNoItemsText('No orders found.');
        $table->withLoadErrorText('An error occured in getting the orders.');
        $table->withAlpine();
        $table->withOpacity(50);

        $data['table'] = $table;
        // ------------------------------------------------------------------

        return $plate->render('orders.index', $data);
    }
}
