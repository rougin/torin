<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexter\Http\Response;
use Rougin\Dexter\Route;
use Rougin\Dextra\Depot;
use Rougin\Gable\Table;
use Rougin\Torin\Checks\ClientCheck;
use Rougin\Torin\Depots\ClientDepot;
use Rougin\Torin\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Clients extends Route
{
    /**
     * @var \Rougin\Torin\Checks\ClientCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $client;

    /**
     * @param \Rougin\Torin\Checks\ClientCheck $check
     * @param \Rougin\Torin\Depots\ClientDepot $client
     */
    public function __construct(ClientCheck $check, ClientDepot $client)
    {
        $this->check = $check;

        $this->client = $client;
    }

    /**
     * @param \Rougin\Torin\Plate $plate
     *
     * @return string
     */
    public function page(Plate $plate)
    {
        $data = array('depot' => new Depot('clients'));

        // Prepare the pagination -------------------
        $total = $this->client->getTotal();

        $pagee = $plate->setPagee('clients', $total);

        $data['pagee'] = $pagee;
        // ------------------------------------------

        // Generate the HTML table ----------------------------------------------
        $table = new Table;
        $table->withAlpine();
        $table->setClass('table mb-0');
        $table->newColumn();

        $table->setCell('Type', 'left')
            ->addBadge('Customer', 'text-bg-success', 'item.type === 0')
            ->addBadge('Supplier', 'text-bg-primary', 'item.type === 1')
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
        $table->withEmptyText('No clients found.');
        $table->withErrorText('An error occured in getting the clients.');
        $table->withOpacity(50);

        $data['table'] = $table;
        // ----------------------------------------------------------------------

        return $plate->render('clients/index', $data);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function select()
    {
        return Response::toJson($this->client->getSelect());
    }

    /**
     * Returns a response if the validation failed.
     *
     * @param integer $code
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalid($code = 400)
    {
        $data = $this->check->errors();

        // HTTP 404 means the row does not exists ---
        if ($code === 404)
        {
            $data = 'Client not found';
        }
        // ------------------------------------------

        return Response::toJson($data, $code);
    }

    /**
     * Checks if the payload data is valid.
     *
     * @param array<string, mixed> $data
     * @param integer              $id
     *
     * @return boolean
     */
    protected function isDataValid($data, $id = 0)
    {
        return $this->check->valid($data);
    }

    /**
     * Checks if the specified item can be shown or deleted.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function isRowValid($id)
    {
        return $this->client->rowExists($id);
    }

    /**
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $this->client->delete($id);

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

        $result = $this->client->get($page, $limit);

        $clients = $result->toArray();

        return Response::toJson($clients);
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->client->create($parsed);

        return Response::toJson('Created!', 201);
    }

    /**
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setUpdateData($id, $parsed)
    {
        $this->client->update($id, $parsed);

        return Response::toJson('Updated!', 204);
    }
}
