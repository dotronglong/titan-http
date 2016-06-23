<?php namespace Titan\Http;

interface MessageInterface
{
    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_HTML = 'text/html';
    const CONTENT_TYPE_TEXT = 'text/plain';
    const CONTENT_TYPE_XML  = 'text/xml';

    /**
     * Get instance of header
     *
     * @return HeadersInterface
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
     * @param HeadersInterface $headers
     * @return self
     */
    public function setHeaders(HeadersInterface $headers);

    /**
     * Set the HTTP protocol version
     *
     * @param string $version
     * @return self
     */
    public function setProtocolVersion($version);
}