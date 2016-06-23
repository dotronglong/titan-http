<?php namespace Titan\Http;

class Message implements MessageInterface
{
    /**
     * @type string
     */
    private $protocolVersion = '1.1';

    /**
     * @type HeadersInterface
     */
    private $headers;

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function setHeaders(HeadersInterface $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @inheritDoc
     */
    public function setProtocolVersion($version)
    {
        $this->protocolVersion = $version;
    }
}