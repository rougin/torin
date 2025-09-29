<?php

namespace Rougin\Torin\Fixture\Fakes;

use Rougin\Fortem\Plate;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FakePlate extends Plate
{
    /**
     * @var string|null
     */
    protected $template;

    /**
     * @var array<string, mixed>
     */
    protected $data = array();

    // Override constructor to avoid calling parent's constructor
    public function __construct()
    {
        // Do nothing, or initialize properties specific to the fake
    }

    /**
     * @param string               $template
     * @param array<string, mixed> $data
     *
     * @return string
     */
    public function render($template, $data = array())
    {
        $this->template = $template;
        $this->data = $data;
        return 'rendered_html_from_fake_plate'; // Return a dummy string
    }

    /**
     * @return \Rougin\Torin\Fixture\Fakes\FakeLinkHelper
     */
    public function getLinkHelper()
    {
        return new FakeLinkHelper;
    }

    /**
     * @return string|null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData()
    {
        return $this->data;
    }
}
