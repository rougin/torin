<?php

namespace Rougin\Torin\Routes;

use Rougin\Dextra\Depot;
use Rougin\Dexter\Filter;
use Rougin\Dexter\Message\JsonResponse;
use Rougin\Dexter\Route;
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
        return new JsonResponse($this->item->getSelect());
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidDelete()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidUpdate()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return $this->item->rowExists($id);
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
     * Checks if the specified item can be updated.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isUpdateValid($id, $parsed)
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
        $this->item->delete($id);

        return new JsonResponse('Deleted!', 204);
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

        return new JsonResponse($result->toArray());
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->item->create($parsed);

        return new JsonResponse('Created!', 201);
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

        return new JsonResponse('Updated!', 204);
    }
}
