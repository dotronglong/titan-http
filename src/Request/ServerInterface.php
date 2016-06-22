<?php namespace Titan\Http\Request;

use Titan\Common\BagInterface;

interface ServerInterface extends BagInterface
{
    /**
     * @return string
     */
    public function getRequestUri();
}
