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
     */
    public function __construct($path, $name = '.env')
    {
        $this->name = $name;

        $this->path = $path;
    }

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

        if (! is_array($lines))
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

            $label = trim($lines[0]);

            $value = trim($lines[1]);

            $label = $this->cleanLabel($label);

            $value = $this->cleanValue($value);

            $value = $this->resolveNested($value);

            $this->setEnv($label, $value);
        }
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
            $nested = $this->getEnv($name);

            if ($nested === null)
            {
                continue;
            }

            $search = $matches[0][$index];

            $value = str_replace($search, $nested, $value);
        }

        return $value;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    protected function getEnv($name)
    {
        if (array_key_exists($name, $_ENV))
        {
            return $_ENV[$name];
        }

        if (array_key_exists($name, $_SERVER))
        {
            return $_SERVER[$name];
        }

        $value = getenv($name);

        return $value === false ? null : $value;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    protected function setEnv($name, $value)
    {
        if ($this->getEnv($name) !== null)
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
}
