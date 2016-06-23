<?php namespace Titan\Http\Request;

use Titan\Common\BagTrait;

class Server implements ServerInterface
{
    use BagTrait;

    const REQUEST_URI    = 'REQUEST_URI';
    const REQUEST_METHOD = 'REQUEST_METHOD';
    const SERVER_NAME    = 'SERVER_NAME';
    const QUERY_STRING   = 'QUERY_STRING';

    public function __construct(array $server = [])
    {
        $this->replace($server);
    }

    /**
     * @inheritDoc
     */
    public function getRequestUri()
    {
        return $this->get(static::REQUEST_URI, '');
    }

    /**
     * @inheritDoc
     */
    public function getRequestMethod()
    {
        return $this->get(static::REQUEST_METHOD);
    }

    /**
     * @inheritDoc
     */
    public function getServerName()
    {
        return $this->get(static::SERVER_NAME);
    }

    /**
     * @inheritDoc
     */
    public function getQueryString()
    {
        return $this->get(static::QUERY_STRING);
    }
}
