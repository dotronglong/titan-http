<?php namespace Titan\Http\Request;

use Titan\Common\BagTrait;

class Server implements ServerInterface
{
    use BagTrait;

    const REQUEST_URI = 'REQUEST_URI';

    /**
     * @inheritDoc
     */
    public function getRequestUri()
    {
        return $this->get(static::REQUEST_URI, '');
    }
}
