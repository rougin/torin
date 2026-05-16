<?php

namespace Rougin\Torin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Dotenv
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     * @param string $name
     *
     * @return void
     */
    public static function load($path, $name = '.env')
    {
        $dotenv = new self($path, $name);

        $dotenv->run();
    }

    /**
     * @param string $path
     * @param string $name
     */
    public function __construct($path, $name = '.env')
    {
        $this->name = $name;

        $this->path = $path;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function get($name)
    {
        if (array_key_exists($name, $_ENV))
        {
            /** @var string|null */
            $value = $_ENV[$name];

            return $value;
        }

        if (array_key_exists($name, $_SERVER))
        {
            /** @var string|null */
            $value = $_SERVER[$name];

            return $value;
        }

        $value = getenv($name);

        return $value === false ? null : $value;
    }

    /**
     * @return void
     */
    public function run()
    {
        // Specify the environment file from path ----
        $slash = DIRECTORY_SEPARATOR;

        $file = rtrim($this->path, $slash);

        $file .= $slash . $this->name;

        if (! is_readable($file) || ! is_file($file))
        {
            $error = 'File "' . $file . '" not found';

            throw new \Exception($error);
        }
        // -------------------------------------------

        // Get the total lines from the environment file ------
        $flags = FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES;

        $lines = file($file, $flags);

        if ($lines === false || count($lines) === 0)
        {
            $error = 'File "' . $file . '" is empty';

            throw new \Exception($error);
        }
        // ----------------------------------------------------

        foreach ($lines as $line)
        {
            $line = trim($line);

            if (empty($line) || $line[0] === '#')
            {
                continue;
            }

            if (strpos($line, '=') === false)
            {
                continue;
            }

            $lines = explode('=', $line, 2);

            $label = $this->cleanLabel(trim($lines[0]));

            $value = $this->cleanValue(trim($lines[1]));

            $value = $this->resolveNested($value);

            $this->set($label, $value);
        }
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function set($name, $value)
    {
        if ($this->get($name) !== null)
        {
            return;
        }

        if (function_exists('putenv'))
        {
            putenv($name . '=' . $value);
        }

        $_ENV[$name] = $value;

        $_SERVER[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function cleanLabel($name)
    {
        $search = array('export ', '\'', '"');

        return trim(str_replace($search, '', $name));
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function cleanValue($value)
    {
        if ($value === '')
        {
            return '';
        }

        if ($value[0] === '"' || $value[0] === '\'')
        {
            return trim($value, $value[0]);
        }

        $parts = explode(' #', $value, 2);

        return trim($parts[0]);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function resolveNested($value)
    {
        if (strpos($value, '$') === false)
        {
            return $value;
        }

        $search = '/\${([a-zA-Z0-9_.]+)}/';

        preg_match_all($search, $value, $matches);

        foreach ($matches[1] as $index => $name)
        {
            $nested = $this->get($name);

            if ($nested === null)
            {
                continue;
            }

            $search = $matches[0][$index];

            $value = str_replace($search, $nested, $value);
        }

        return $value;
    }
}
