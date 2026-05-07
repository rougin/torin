<?php

namespace Rougin\Torin\Pages;

use Rougin\Dextra\Depot;
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
        $table->withAlpine();
        $table->newColumn();

        $table->setCell('Type', 'left')->withWidth(5);
        $table->addBadge('Purchase', 'text-bg-primary', 'item.type === TYPE_PURCHASE');
        $table->addBadge('Sales', 'text-bg-success', 'item.type === TYPE_SALE');
        $table->addBadge('Transfer', 'text-bg-secondary', 'item.type === TYPE_TRANSFER');
        $table->setCell('Status', 'left')->withWidth(5);
        $table->addBadge('Cancelled', 'text-bg-danger', 'item.status === STATUS_CANCELLED');
        $table->addBadge('Fulfilled', 'text-bg-success', 'item.status === STATUS_COMPLETED');
        $table->addBadge('Pending', 'text-bg-warning', 'item.status === STATUS_PENDING');
        $table->setCell('Order Code', 'left')->withName('code')->withWidth(13);
        $table->setCell('Client Name', 'left')->withName('client.name');
        $table->setCell('Remarks', 'left')->withName('remarks');
        $table->setCell('Created At', 'left')->withWidth(14);
        $table->setCell('Updated At', 'left')->withWidth(14);

        $table->withActions(null, 'left')->withWidth(5);
        $action = new Action;
        $action->setName('Mark as Complete');
        $action->ifClicked('mark(item, STATUS_COMPLETED)');
        $action->withAlpine();
        $table->addAction($action);
        $table->withUpdateAction('edit(item)');
        $table->withDeleteAction('trash(item)');

        $table->withLoading();
        $table->withEmptyText('No orders found.');
        $table->withErrorText('An error occured in getting the orders.');
        $table->withOpacity(50);

        $data['table'] = $table;
        // ----------------------------------------------------------------------------------

        return $this->render('orders/index', $data);
    }
}
