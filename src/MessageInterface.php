<?php namespace Titan\Http;

interface MessageInterface
{
    /**
     * Get instance of header
     *
     * @return HeaderInterface
     */
    public function getHeaders();

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * @return string
     */
    public function getProtocolVersion();

    /**
     * Set instance of header
     *
     * @param HeaderInterface $headers
     * @return self
     */
    public function setHeaders(HeaderInterface $headers);

    /**
     * Set the HTTP protocol version
     *
     * @param string $version
     * @return self
     */
    public function setProtocolVersion($version);
}