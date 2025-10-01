<?php

namespace Rougin\Torin\Pages;

use Rougin\Dexterine\Depot;
use Rougin\Gable\Action;
use Rougin\Gable\Table;
use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders extends Page
{
    /**
     * @param \Rougin\Torin\Depots\OrderDepot $order
     *
     * @return string
     */
    public function index(OrderDepot $order)
    {
        $data = array('depot' => new Depot('orders'));

        // Prepare the pagination -----------------
        $total = $order->getTotal();

        $pagee = $this->setPagee('orders', $total);

        $data['pagee'] = $pagee;
        // ----------------------------------------

        // Generate the HTML table ----------------------------------------------------------
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Type', 'left')->withWidth(5);
        $table->addBadge('Purchase', 'item.type === TYPE_PURCHASE', 'text-bg-primary');
        $table->addBadge('Sales', 'item.type === TYPE_SALE', 'text-bg-success');
        $table->addBadge('Transfer', 'item.type === TYPE_TRANSFER', 'text-bg-secondary');
        $table->setCell('Status', 'left')->withWidth(5);
        $table->addBadge('Cancelled', 'item.status === STATUS_CANCELLED', 'text-bg-danger');
        $table->addBadge('Fulfilled', 'item.status === STATUS_COMPLETED', 'text-bg-success');
        $table->addBadge('Pending', 'item.status === STATUS_PENDING', 'text-bg-warning');
        $table->setCell('Order Code', 'left')->withName('code')->withWidth(13);
        $table->setCell('Client Name', 'left')->withName('client.name');
        $table->setCell('Remarks', 'left')->withName('remarks');
        $table->setCell('Created At', 'left')->withWidth(14);
        $table->setCell('Updated At', 'left')->withWidth(14);

        $table->withActions(null, 'left')->withWidth(5);
        $action = new Action;
        $action->setName('Mark as Complete');
        $action->ifClicked('mark(item, STATUS_COMPLETED)');
        $table->addAction($action);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');

        $table->withLoading();
        $table->withNoItemsText('No orders found.');
        $table->withLoadErrorText('An error occured in getting the orders.');
        $table->withAlpine();
        $table->withOpacity(50);

        $data['table'] = $table;
        // ----------------------------------------------------------------------------------

        return $this->render('orders/index', $data);
    }
}
