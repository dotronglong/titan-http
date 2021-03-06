<?php namespace Titan\Http;

use Titan\Http\Routing\RouteInterface;

interface RouterInterface
{
    /**
     * Route a specified request and return appropriate route instance
     *
     * @param RequestInterface $request
     * @return RouteInterface|null
     */
    public function route(RequestInterface $request);

    /**
     * Get all routes
     *
     * @return RouteInterface[]
     */
    public function getRoutes();

    /**
     * Replace all routes
     *
     * @param RouteInterface[] $routes
     * @return self
     */
    public function setRoutes(array $routes);

    /**
     * Add route to router
     *
     * @param RouteInterface $route
     * @return self
     */
    public function addRoute(RouteInterface $route);

    /**
     * Get a route by name
     *
     * @param string $name
     * @return RouteInterface
     */
    public function getRoute($name);

    /**
     * Remove a route by name
     *
     * @param string $name
     * @return self
     */
    public function removeRoute($name);

    /**
     * Remove all routes in router
     *
     * @return self
     */
    public function removeRoutes();
}