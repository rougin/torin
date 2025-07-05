<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Fortem\Plate;
use Rougin\Gable\Pagee;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class Page
{
    /**
     * @var \Rougin\Fortem\Plate
     */
    protected $plate;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @param \Rougin\Fortem\Plate                     $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(Plate $plate, ServerRequestInterface $request)
    {
        $this->plate = $plate;

        $this->request = $request;
    }

    /**
     * @param string  $name
     * @param integer $total
     *
     * @return \Rougin\Gable\Pagee
     */
    protected function pagee($name, $total)
    {
        $pagee = Pagee::fromRequest($this->request);

        $link = $this->plate->getLinkHelper();

        $pagee->asAlpine()->setTotal($total);

        return $pagee->setLink($link->set($name));
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $data
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function render($name, $data = array())
    {
        return $this->plate->render($name, $data);
    }
}
