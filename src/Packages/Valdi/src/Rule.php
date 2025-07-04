<?php

namespace Rougin\Valdi;

use Valitron\Validator;

/**
 * @package Valdi
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Rule
{
    /**
     * @var \Valitron\Validator
     */
    protected $valid;

    /**
     * @param \Valitron\Validator $valid
     */
    public function __construct(Validator $valid)
    {
        $this->valid = $valid;
    }

    /**
     * Parses the specified rule against its value.
     *
     * @param string $rule
     * @param string $value
     *
     * @return \Valitron\Validator
     */
    public function parse($rule, $value)
    {
        // Break down multiple rules ---
        $items = explode('|', $value);
        // -----------------------------

        foreach ($items as $item)
        {
            // Parse each rule --------
            $this->check($item, $rule);
            // ------------------------
        }

        return $this->valid;
    }

    /**
     * Checks the specified rules.
     *
     * @param string $item
     * @param string $field
     *
     * @return void
     */
    protected function check($item, $field)
    {
        $details = explode(':', $item);

        $name = trim($details[0]);

        $values = [];

        // Extract all dependency fields/values ---
        if (count($details) > 1)
        {
            $details[1] = trim($details[1]);

            /** @var string[] */
            $values = explode(',', $details[1]);
        }
        // ----------------------------------------

        if ($name === 'contains')
        {
            /** @var string */
            $value = end($values);

            if (trim($value) === 'true')
            {
                $this->valid->rule($name, $field, $values, true);

                return;
            }

            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'creditCard')
        {
            if (count($values) === 1)
            {
                $value = trim($values[0]);

                $this->valid->rule($name, $field, $value);

                return;
            }

            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'in')
        {
            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'instanceOf')
        {
            $value = trim($values[0]);

            // TODO: Setup ContainerInterface for autowiring ---
            $value = new $value;
            // -------------------------------------------------

            $this->valid->rule($name, $field, $value);

            return;
        }

        if ($name === 'notIn')
        {
            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'required')
        {
            if (count($values) && trim(end($values)) === 'true')
            {
                $this->valid->rule($name, $field, true);

                return;
            }
        }

        if ($name === 'requiredWith')
        {
            if (count($values) && trim(end($values)) === 'true')
            {
                $this->valid->rule($name, $field, $values, true);

                return;
            }

            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'requiredWithout')
        {
            if (count($values) && trim(end($values)) === 'true')
            {
                $this->valid->rule($name, $field, $values, true);

                return;
            }

            $this->valid->rule($name, $field, $values);

            return;
        }

        if ($name === 'subset')
        {
            $this->valid->rule($name, $field, $values);

            return;
        }

        // Rule without fields/values --------
        if (count($values) === 0)
        {
            $this->valid->rule($name, $field);
        }
        // -----------------------------------

        // Rule with only 1 value/field ----------------------------
        if ((count($values) === 1) && trim(end($values)) !== 'true')
        {
            $this->valid->rule($name, $field, trim($values[0]));
        }
        // ---------------------------------------------------------
    }
}
