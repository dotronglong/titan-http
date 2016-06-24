<?php namespace Titan\Http\Routing;

use Titan\Http\Exception\InvalidArgumentException;
use Titan\Http\UriInterface;

interface RouteInterface
{
    const ROUTE_TYPE    = 'type';
    const ROUTE_NAME    = 'name';
    const ROUTE_HOST    = 'host';
    const ROUTE_PATH    = 'path';
    const ROUTE_METHODS = 'methods';
    const ROUTE_DEMANDS = 'demands';
    const ROUTE_MATCHES = 'matches';

    /**
     * Get name of route
     *
     * @return string
     */
    public function getName();

    /**
     * Set name of route
     *
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * Get type of route
     *
     * Each route has a unique type which has to be registered with the router.
     * When a route is added, router defines which Route class will be loaded base on this type
     *
     * @return string
     */
    public function getType();

    /**
     * Set type of route
     *
     * @param string $type
     * @return self
     */
    public function setType($type);

    /**
     * Get host of route
     *
     * Each route has a host which defines the host effected. If the host is null, it should consider there is no need
     * to compare to the host
     *
     * @return string
     */
    public function getHost();

    /**
     * Set host of route
     *
     * It MUST throw an exception if provided host is not a valid string
     *
     * @param string $host
     * @return self
     * @throws InvalidArgumentException
     */
    public function setHost($host);

    /**
     * Get path of route
     *
     * Each route has a path which to be compared to URI's path
     *
     * @return string
     */
    public function getPath();

    /**
     * Set path of route
     *
     * It MUST throw an exception if provided path is not a valid string
     *
     * @param string $path
     * @return self
     * @throws InvalidArgumentException
     */
    public function setPath($path);

    /**
     * Get methods of route
     *
     * Route can have many methods at one time
     *
     * @return string
     */
    public function getMethods();

    /**
     * Set methods of route
     *
     * @param array $methods
     * @return self
     */
    public function setMethods(array $methods);

    /**
     * Get demands of route
     *
     * Demands are using to check an argument of route's path to match specified demands.
     * NOTE: These demands effect both host and path of route.
     *
     * @return array
     */
    public function getDemands();

    /**
     * Set demands of route
     *
     * @param array $demands
     * @return self
     */
    public function setDemands(array $demands);

    /**
     * Get matches of route
     *
     * Matches are values that will be retrieved when a route is matched
     *
     * @return array
     */
    public function getMatches();

    /**
     * Set matches of route
     *
     * @param array $matches
     * @return self
     */
    public function setMatches(array $matches);

    /*
     * Returns whether this route matches uri or not
     *
     * @return bool
     */
    public function match(UriInterface $uri);
}