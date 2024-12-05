<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithStoreMethod;
use Rougin\Gable\Table;
use Rougin\Temply\Plate;
use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items
{
    use WithStoreMethod;

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
     * @param \Rougin\Temply\Plate $plate
     *
     * @return string
     */
    public function index(Plate $plate)
    {
        $table = new Table;
        $table->setClass('table mb-0');

        $table->newColumn();
        $table->setCell('Code', 'left')->withWidth(1);
        $table->setCell('Name', 'left')->withWidth(5);
        $table->setCell('Description', 'left')->withWidth(10)->withName('detail');
        $table->setCell('Action', 'left')->withWidth(1);

        $data = array('table' => $table);

        return $plate->render('items.index', $data);
    }

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $code = HttpResponse::UNPROCESSABLE;

        $errors = $this->check->errors();

        return new JsonResponse($errors, $code);
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
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        // $this->item->create($parsed);

        return new JsonResponse('Created!', 201);
    }
}
