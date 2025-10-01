<?php

namespace Rougin\Torin\Fixture\Stubs;

use Rougin\Fortem\Plate;
use Staticka\Render\RenderInterface;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class StubRender extends Plate implements RenderInterface
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var array<string, mixed>
     */
    protected $data = [];

    public function __construct()
    {
        // Override constructor to avoid calling parent's constructor
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $data
     *
     * @return string
     */
    public function render($name, $data = [])
    {
        $this->name = $name;

        $this->data = $data;

        return 'rendered_html_from_stub_render';
    }

    /**
     * @return string|null
     */
    public function getTemplate()
    {
        return $this->name;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData()
    {
        return $this->data;
    }
}
