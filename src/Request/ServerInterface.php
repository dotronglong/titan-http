<?php namespace Titan\Http\Request;

use Titan\Common\BagInterface;

interface ServerInterface extends BagInterface
{
    /**
     * @return string
     */
    public function getRequestUri();

    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @return string
     */
    public function getServerName();

    /**
     * @return string
     */
    public function getQueryString();
}
