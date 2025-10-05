<?php

namespace Rougin\Torin\Pages;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Hello extends Page
{
    /**
     * @return string
     */
    public function index()
    {
        return $this->render('index');
    }
}
