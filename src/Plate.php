<?php

namespace Rougin\Torin;

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
class Plate
{
    /**
     * @var \Rougin\Fortem\Helpers\LinkHelper
     */
    protected $link;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Staticka\Render\RenderInterface
     */
    protected $self;

    /**
     * @param \Staticka\Render\RenderInterface         $render
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(RenderInterface $render, ServerRequestInterface $request)
    {
        $this->request = $request;

        /** @var array<string, string> */
        $server = $request->getServerParams();

        $this->self = $render;

        $this->link = new LinkHelper($server);
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $data
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function render($name, $data = array())
    {
        // Initialize the list of helpers ---------
        $helpers = array($this->link);

        $form = new FormHelper;

        $helpers[] = $form->withAlpine();

        $helpers[] = new PlateHelper($this->self);

        $helpers[] = new BlockHelper;

        $helpers[] = new LayoutHelper($this->self);
        // ----------------------------------------

        foreach ($helpers as $helper)
        {
            $data[$helper->name()] = $helper;
        }

        $html = $this->self->render($name, $data);

        // Initialize the list of filters ---
        $filters = array(new LayoutFilter);
        // ----------------------------------

        foreach ($filters as $filter)
        {
            $html = $filter->filter($html);
        }

        return $html;
    }

    /**
     * @param string  $name
     * @param integer $total
     *
     * @return \Rougin\Gable\Pagee
     */
    public function setPagee($name, $total)
    {
        $pagee = new Pagee;

        $pagee->asAlpine();

        /** @var array<string, string> */
        $params = $this->request->getQueryParams();

        $key = $pagee->getLimitKey();

        if (array_key_exists($key, $params))
        {
            $pagee->setLimit((int) $params[$key]);
        }

        $key = $pagee->getPageKey();

        if (array_key_exists($key, $params))
        {
            $pagee->setPage((int) $params[$key]);
        }

        $pagee->setTotal($total);

        $url = $this->link->set($name);

        return $pagee->setLink($url);
    }
}
