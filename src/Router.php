<?php namespace Titan\Http;

use Titan\Http\Routing\RouteInterface;

class Router implements RouterInterface
{
    /**
     * @var RouteInterface[]
     */
    private $routes = [];

    /**
     * @inheritDoc
     */
    public function route(RequestInterface $request)
    {
        foreach ($this->routes as $route) {
            if ($route->match($request->getUri())) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @inheritDoc
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoute($name)
    {
        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function removeRoute($name)
    {
        foreach ($this->routes as $i => $route) {
            if ($route->getName() === $name) {
                unset($this->routes[$i]);
                break;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeRoutes()
    {
        $this->routes = [];

        return $this;
    }
}