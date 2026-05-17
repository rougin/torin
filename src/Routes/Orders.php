<?php

namespace Rougin\Torin\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexter\Http\Response;
use Rougin\Dexter\Route;
use Rougin\Dextra\Depot;
use Rougin\Gable\Action;
use Rougin\Gable\Table;
use Rougin\Torin\Checks\CartCheck;
use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Depots\OrderDepot;
use Rougin\Torin\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders extends Route
{
    /**
     * @var \Rougin\Torin\Checks\OrderCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $order;

    /**
     * @param \Rougin\Torin\Checks\OrderCheck $check
     * @param \Rougin\Torin\Depots\OrderDepot $order
     */
    public function __construct(OrderCheck $check, OrderDepot $order)
    {
        $this->check = $check;

        $this->order = $order;
    }

    /**
     * @param \Rougin\Torin\Depots\ItemDepot           $item
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function check(ItemDepot $item, ServerRequestInterface $request)
    {
        $check = new CartCheck($item);

        if (! $check->isParsedValid($request))
        {
            return Response::toJson($check->firstError(), 422);
        }

        return Response::toJson(true);
    }

    /**
     * @param \Rougin\Torin\Plate $plate
     *
     * @return string
     */
    public function page(Plate $plate)
    {
        $data = array('depot' => new Depot('orders'));

        // Prepare the pagination ------------------
        $total = $this->order->getTotal();

        $pagee = $plate->setPagee('orders', $total);

        $data['pagee'] = $pagee;
        // -----------------------------------------

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

        return $plate->render('orders/index', $data);
    }

    /**
     * @param integer                                  $id
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function status($id, ServerRequestInterface $request)
    {
        /** @var array<string, string> */
        $data = $request->getParsedBody();

        $status = (int) $data['status'];

        $this->order->changeStatus($id, $status);

        return Response::toJson(true, 204);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidDelete()
    {
        $errors = $this->check->errors();

        return Response::toJson($errors, 422);
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $errors = $this->check->errors();

        return Response::toJson($errors, 422);
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return $this->order->rowExists($id);
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isStoreValid($parsed)
    {
        return $this->check->valid($parsed);
    }

    /**
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $this->order->delete($id);

        return Response::toJson('Deleted!', 204);
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $limit = 10;

        if (array_key_exists('l', $params))
        {
            /** @var integer */
            $limit = $params['l'];
        }

        $page = 1;

        if (array_key_exists('p', $params))
        {
            /** @var integer */
            $page = $params['p'];
        }

        $result = $this->order->get($page, $limit);

        $items = $result->toArray();

        return Response::toJson($items);
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->order->create($parsed);

        return Response::toJson('Created!', 201);
    }
}
