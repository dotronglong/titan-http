<?php namespace Titan\Http\Routing;

use Titan\Http\UriInterface;

interface RouteInterface
{
    /*
     * Returns whether this route matches uri or not
     *
     * @return bool
     */
    public function match(UriInterface $uri);
}