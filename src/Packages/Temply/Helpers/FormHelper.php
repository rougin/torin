<?php

namespace Rougin\Temply\Helpers;

use Rougin\Temply\Button;
use Rougin\Temply\Error;
use Rougin\Temply\Input;
use Rougin\Temply\Label;
use Rougin\Temply\Script;
use Staticka\Helper\HelperInterface;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FormHelper implements HelperInterface
{
    /**
     * @var boolean
     */
    protected $alpine = false;

    /**
     * @param string      $text
     * @param string|null $class
     *
     * @return \Rougin\Temply\Button
     */
    public function button($text, $class = null)
    {
        $elem = new Button($text);

        if ($class)
        {
            $elem->withClass($class);
        }

        return $elem;
    }

    /**
     * TODO: This is a specific code for "alpinejs".
     *
     * @param string $field
     *
     * @return \Rougin\Temply\Error
     */
    public function error($field)
    {
        return new Error($field);
    }

    /**
     * @param string      $name
     * @param string|null $class
     *
     * @return \Rougin\Temply\Input
     */
    public function input($name, $class = null)
    {
        $elem = new Input($name);

        if ($class)
        {
            $elem->withClass($class);
        }

        return $elem;
    }

    /**
     * @param string      $text
     * @param string|null $class
     *
     * @return \Rougin\Temply\Label
     */
    public function label($text, $class = null)
    {
        $elem = new Label($text);

        if ($class)
        {
            $elem->withClass($class);
        }

        return $elem;
    }

    /**
     * Returns the name of the helper.
     *
     * @return string
     */
    public function name()
    {
        return 'form';
    }

    /**
     * @param string $name
     *
     * @return \Rougin\Temply\Script
     */
    public function script($name)
    {
        return new Script($name);
    }

    /**
     * @return self
     */
    public function withAlpine()
    {
        $this->alpine = true;

        return $this;
    }

    /**
     * @return self
     */
    public function withoutAlpine()
    {
        $this->alpine = false;

        return $this;
    }
}
