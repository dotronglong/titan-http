<?php namespace Titan\Tests\Http\Routing;

use Titan\Tests\Common\TestCase;
use Titan\Http\Routing\Route;
use Titan\Http\Exception\InvalidArgumentException;

class RouteTest extends TestCase
{
    private function getInstance()
    {
        return $this->getMockForAbstractClass(Route::class);
    }

    public function testGetSetType()
    {
        $type  = 'my_type';
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setType($type));
        $this->assertEquals($type, $route->getType());
    }

    public function testGetSetName()
    {
        $name  = 'my_name';
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setName($name));
        $this->assertEquals($name, $route->getName());
    }

    public function testGetSetHost()
    {
        $host  = 'domain.com';
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setHost($host));
        $this->assertEquals($host, $route->getHost());
    }

    public function testSetHostExpectInvalidArgumentException()
    {
        $route = $this->getInstance();
        $this->expectException(InvalidArgumentException::class);
        $this->assertEquals($route, $route->setHost([]));
    }
}