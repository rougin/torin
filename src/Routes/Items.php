<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexter\Filter;
use Rougin\Dexter\Http\Response;
use Rougin\Dexter\Route;
use Rougin\Dextra\Depot;
use Rougin\Gable\Table;
use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items extends Route
{
    /**
     * @var \Rougin\Torin\Checks\ItemCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $item;

    /**
     * @param \Rougin\Torin\Checks\ItemCheck $check
     * @param \Rougin\Torin\Depots\ItemDepot $item
     */
    public function __construct(ItemCheck $check, ItemDepot $item)
    {
        $this->check = $check;

        $this->item = $item;
    }

    /**
     * @param \Rougin\Torin\Plate $plate
     *
     * @return string
     */
    public function page(Plate $plate)
    {
        $data = array('depot' => new Depot('items'));

        // Prepare the pagination -----------------
        $total = $this->item->getTotal();

        $pagee = $plate->setPagee('items', $total);

        $data['pagee'] = $pagee;
        // ----------------------------------------

        // Generate the HTML table -----------------------------------------------
        $table = new Table;
        $table->withAlpine();
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
        $table->withOpacity(50);

        $data['table'] = $table;
        // -----------------------------------------------------------------------

        return $plate->render('items/index', $data);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function select()
    {
        return Response::toJson($this->item->getSelect());
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
            $data = 'Item not found';
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
        return $this->item->rowExists($id);
    }

    /**
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $this->item->delete($id);

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

        $search = null;

        if (array_key_exists('k', $params))
        {
            /** @var string|null */
            $search = $params['k'];
        }

        // Add filter to search items by keyword ------
        if ($search)
        {
            $filter = new Filter;

            $filter->setStr('name', $search);
            $filter->setStr('code', $search);

            $filter->withSearch(array('name', 'code'));

            $this->item->withFilter($filter);
        }
        // --------------------------------------------

        $result = $this->item->get($page, $limit);

        return Response::toJson($result->toArray());
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->item->create($parsed);

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
        $this->item->update($id, $parsed);

        return Response::toJson('Updated!', 204);
    }
}
