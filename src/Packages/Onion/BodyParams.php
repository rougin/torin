<?php

namespace Rougin\Onion;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * @package Onion
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class BodyParams implements MiddlewareInterface
{
    /**
     * @var string[]
     */
    protected $complex = array('PATCH', 'PUT', 'DELETE');

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface      $request
     * @param \Rougin\Slytherin\Middleware\HandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $method = (string) $request->getMethod();

        if (! in_array($method, $this->complex))
        {
            return $handler->handle($request);
        }

        $post = (array) $request->getParsedBody();

        /** @var string */
        $contents = file_get_contents('php://input');

        /** @var array<string, string> */
        $parsed = array();

        parse_str((string) $contents, $parsed);

        if (strpos($contents, 'form-data') !== false)
        {
            $parsed = $this->parseRequest($contents);
        }

        $parsed = array_merge($post, (array) $parsed);

        $request = $request->withParsedBody($parsed);

        return $handler->handle($request);
    }

    /**
     * https://stackoverflow.com/a/38624774
     *
     * @param string $input
     *
     * @return array<mixed, mixed>
     */
    protected function parseRequest($input)
    {
        $endOfFirstLine = (int) strpos($input, "\r\n");

        $boundary = substr($input, 0, $endOfFirstLine);

        // Split form-data into each entry ---
        /** @var array<string> */
        $parts = explode($boundary, $input);
        // -----------------------------------

        /** @var array<string, string> */
        $return = array();

        $header = array();

        // Remove first and last (null) entries ---
        array_shift($parts);

        array_pop($parts);
        // ----------------------------------------

        foreach ($parts as $part)
        {
            $endOfHead = strpos($part, "\r\n\r\n");

            $startOfBody = $endOfHead + 4;

            $head = substr($part, 2, $endOfHead - 2);

            $body = substr($part, $startOfBody, -2);

            /** @var array<string> */
            $headerParts = preg_split('#; |\r\n#', $head);

            $key = null;

            $thisHeader = array();

            // Parse the mini headers, obtain the key
            foreach ($headerParts as $headerPart)
            {
                if (! preg_match('#(.*)(=|: )(.*)#', $headerPart, $keyVal))
                {
                    continue;
                }

                if ($keyVal[1] === 'name')
                {
                    $key = substr($keyVal[3], 1, -1);

                    continue;
                }

                if ($keyVal[2] === '=')
                {
                    $thisHeader[$keyVal[1]] = substr($keyVal[3], 1, -1);

                    continue;
                }

                $thisHeader[$keyVal[1]] = $keyVal[3];
            }

            if ($key === null)
            {
            continue;
            }

            // If the key is multidimensional, generate -----------
            // multidimentional array based off of the parts ------
            /** @var array<string> */
            $nameParts = preg_split('#(?=\[.*\])#', (string) $key);
            // ----------------------------------------------------

            if (count($nameParts) < 1)
            {
                $return[$key] = $body;

                if (! isset($thisHeader['filename']))
                {
                    $header[$key] = $thisHeader;
                    continue;
                }

                $filename = tempnam(sys_get_temp_dir(), 'php');

                file_put_contents((string) $filename, $body);

                $item = array('error' => 0);

                $item['name'] = $thisHeader['filename'];

                $item['type'] = $thisHeader['Content-Type'];

                $item['tmp_name'] = $filename;

                $item['size'] = filesize($body);

                $return[$key] = (array) $item;

                $header[$key] = $thisHeader;
                continue;
            }

            /** @var array<string, string> */
            $current = &$return;

            /** @var array<string, string> */
            $currentHeader = &$header;

            $l = count($nameParts);

            for ($i = 0; $i < $l; $i++)
            {
                // Strip the array access tokens ------------------------
                /**
                 * @var string
                 */
                $namePart = preg_replace('#[\[\]]#', '', $nameParts[$i]);
                // ------------------------------------------------------

                // If we are at the end of the depth of this entry,
                // add data to array
                if ($i != $l - 1)
                {
                    // Advance into the array -----------------------------
                    if (is_array($current) && ! isset($current[$namePart]))
                    {
                        if (is_array($currentHeader))
                        {
                            $currentHeader[$namePart] = array();
                        }

                        if (is_array($current))
                        {
                            $current[$namePart] = array();
                        }
                    }
                    // ----------------------------------------------------

                    if (is_array($currentHeader))
                    {
                        $currentHeader = &$currentHeader[$namePart];
                    }

                    if (is_array($current))
                    {
                        $current = &$current[$namePart];
                    }

                    continue;
                }

                if (is_array($current))
                {
                    $current[$namePart] = $body;
                }

                if (isset($thisHeader['filename']))
                {
                    $temp = (string) sys_get_temp_dir();

                    $filename = (string) tempnam($temp, 'php');

                    file_put_contents($filename, $body);

                    $file = array('error' => 0);

                    $file['name'] = $thisHeader['filename'];

                    $file['type'] = $thisHeader['Content-Type'];

                    $file['tmp_name'] = (string) $filename;

                    $file['size'] = filesize($body);

                    if (is_array($current))
                    {
                        $current[$namePart] = (array) $file;
                    }
                }

                if (is_array($currentHeader))
                {
                    $currentHeader[$namePart] = $thisHeader;
                }
            }
        }

        return $return;
    }
}
