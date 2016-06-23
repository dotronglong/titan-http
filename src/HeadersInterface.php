<?php namespace Titan\Http;

use Titan\Common\BagInterface;

interface HeadersInterface extends BagInterface
{
    /**
     * Append value(s) to a current header name.
     * If header's name does not exist, create new one, otherwise put to the end of array
     *
     * @param string       $key
     * @param string|array $value
     * @return self
     */
    public function append($key, $value);

    /**
     * Get all headers as an array of string.
     * Each element of this array will have format: header-name: header-values
     * The values might be a string which separate by commas
     *
     * @return array
     */
    public function lines();

    /**
     * Flush and clean all headers
     */
    public function flush();
}