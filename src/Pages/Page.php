<?php

namespace Rougin\Torin\Pages;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Fortem\Helpers\FormHelper;
use Rougin\Fortem\Helpers\LinkHelper;
use Rougin\Gable\Pagee;
use Staticka\Filter\LayoutFilter;
use Staticka\Helper\BlockHelper;
use Staticka\Helper\LayoutHelper;
use Staticka\Helper\PlateHelper;
use Staticka\Render\RenderInterface;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Page
{
    /**
     * @var \Staticka\Render\RenderInterface
     */
    protected $plate;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @param \Staticka\Render\RenderInterface         $plate
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(RenderInterface $plate, ServerRequestInterface $request)
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
    protected function setPagee($name, $total)
    {
        $pagee = Pagee::fromRequest($this->request);

        $link = $this->getLinkHelper();

        $pagee->asAlpine()->setTotal($total);

        return $pagee->setLink($link->set($name));
    }

    /**
     * TODO: Remove usage of "APP_URL".
     *
     * @return \Rougin\Fortem\Helpers\LinkHelper
     */
    protected function getLinkHelper()
    {
        $server = $this->request->getServerParams();

        /** @var string */
        $link = getenv('APP_URL');

        return new LinkHelper($link, $server);
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
        // Initialize the list of helpers ----------
        $helpers = array($this->getLinkHelper());

        $form = new FormHelper;

        $helpers[] = $form->withAlpine();

        $helpers[] = new PlateHelper($this->plate);

        $helpers[] = new BlockHelper;

        $helpers[] = new LayoutHelper($this->plate);
        // -----------------------------------------

        foreach ($helpers as $helper)
        {
            $data[$helper->name()] = $helper;
        }

        $html = $this->plate->render($name, $data);

        // Initialize the list of filters ---
        $filters = array(new LayoutFilter);
        // ----------------------------------

        foreach ($filters as $filter)
        {
            $html = $filter->filter($html);
        }

        return $html;
    }
}
