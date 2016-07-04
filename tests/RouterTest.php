<?php namespace Titan\Tests\Http;

use Titan\Http\Request;
use Titan\Http\Router;
use Titan\Http\Uri;
use Titan\Tests\Common\TestCase;
use Titan\Http\Routing\Route;

class RouterTest extends TestCase
{
    private $sampleName = 'sample';

    private function getInstance()
    {
        return new Router();
    }

    private function getRouteInstance()
    {
        $route = $this->getMockForAbstractClass(Route::class);
        $route->setName($this->sampleName);

        return $route;
    }

    public function testGetAndAddRoute()
    {
        $route = $this->getRouteInstance();
        $router = $this->getInstance();
        $router->addRoute($route);

        $this->assertEquals($route, $router->getRoute($this->sampleName));
    }

    public function testRemoveRoute()
    {
        $route = $this->getRouteInstance();
        $router = $this->getInstance();
        $router->addRoute($route);
        $router->removeRoute($this->sampleName);
        $this->assertNull($router->getRoute($this->sampleName));
    }

    public function testRemoveAndSetAndGetRoutes()
    {
        $route = $this->getRouteInstance();
        $router = $this->getInstance();
        $router->setRoutes([$route]);
        $router->removeRoutes();
        $this->assertCount(0, $router->getRoutes());
    }

    public function testRoute()
    {
        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->any())->method('getUri')->willReturn(new Uri());

        $route = $this->getRouteInstance();
        $route->expects($this->exactly(2))->method('match')->will($this->onConsecutiveCalls(true, false));

        $route_1 = $this->getRouteInstance();
        $route_1->expects($this->once())->method('match')->willReturn(false);

        $router = $this->getInstance();
        $router->addRoute($route);
        $router->addRoute($route_1);
        $this->assertEquals($route, $router->route($request));
        $this->assertNull($router->route($request));
    }
}