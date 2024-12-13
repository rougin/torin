<?php

namespace Rougin\Dexter\Alpine;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Close extends Method
{
    /**
     * @var string
     */
    protected $name = 'close';

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function ()';
        $fn .= '{';
        $fn .= 'const self = this;';

        foreach ($this->modals as $name => $type)
        {
            $fn .= 'Modal.' . $type . '(\'' . $name . '\');';
        }

        $fn .= 'setTimeout(() =>';
        $fn .= '{';

        $fields = $this->script ? $this->script->getFields() : array();

        foreach ($this->resets as $field)
        {
            $exists = array_key_exists($field, $fields);

            $value = $exists ? $fields[$field] : null;

            /** @var string */
            $value = json_encode($value);

            $fn .= 'self.' . $field . ' = ' . $value . ';';
        }

        $fn .= '}, 1000)';
        $fn .= '}';

        return $fn;
    }
}
