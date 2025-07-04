<?php

namespace Rougin\Valdi;

use Valitron\Validator;

/**
 * @package Valdi
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Check
{
    /**
     * @var array<string, mixed>
     */
    protected $errors = array();

    /**
     * @var array<mixed, mixed>
     */
    protected $data = array();

    /**
     * @var array<string, string>
     */
    protected $labels = array();

    /**
     * @var array<string, string>
     */
    protected $rules = array();

    /**
     * Returns the generated errors after validation.
     *
     * @return array<string, mixed>
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Returns the first error after validation.
     *
     * @return string|null
     */
    public function firstError()
    {
        if (! $this->errors)
        {
            return null;
        }

        /** @var string[][] */
        $values = array_values($this->errors);

        return $values[0][0];
    }

    /**
     * Returns the specified labels.
     *
     * @return array<string, string>
     */
    public function labels()
    {
        return $this->labels;
    }

    /**
     * Returns the specified rules based from the payload.
     *
     * @param array<mixed, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules($data)
    {
        return $this->rules;
    }

    /**
     * Adds a new error message to the specified key.
     *
     * @param string $key
     * @param string $text
     *
     * @return self
     */
    public function setError($key, $text)
    {
        $exists = array_key_exists($key, $this->errors);

        if (! $exists)
        {
            $this->errors[$key] = array();
        }

        /** @var array<string, mixed> */
        $items = $this->errors[$key];

        $items[] = $text;

        $this->errors[$key] = $items;

        return $this;
    }

    /**
     * Checks if the payload is valid againsts the specified rules.
     *
     * @param array<mixed, mixed> $data
     *
     * @return boolean
     */
    public function valid($data = null)
    {
        $valid = new Validator;

        $valid->labels($this->labels());

        // If no payload received, check the data inside ---
        if (! $data)
        {
            $data = $this->data;
        }
        // -------------------------------------------------

        $rules = $this->rules($data);

        foreach ($rules as $key => $value)
        {
            $rule = new Rule($valid);

            $valid = $rule->parse($key, $value);
        }

        $valid = $valid->withData($data);

        if ($valid->validate())
        {
            return count($this->errors) === 0;
        }

        /** @var array<string, string[]> */
        $result = $valid->errors();

        foreach ($result as $name => $errors)
        {
            foreach ($errors as $error)
            {
                $this->setError($name, $error);
            }
        }

        return count($this->errors) === 0;
    }
}
