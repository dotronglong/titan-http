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

    public function testGetSetPath()
    {
        $path  = '/my-path';
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setPath($path));
        $this->assertEquals($path, $route->getPath());
    }

    public function testSetPathExpectInvalidArgumentException()
    {
        $route = $this->getInstance();
        $this->expectException(InvalidArgumentException::class);
        $this->assertEquals($route, $route->setPath([]));
    }

    public function testGetSetMethods()
    {
        $methods = ['GET', 'PUT'];
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setMethods($methods));
        $this->assertEquals($methods, $route->getMethods());
    }

    public function testGetSetDemands()
    {
        $demands = ['id' => '\d+'];
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setDemands($demands));
        $this->assertEquals($demands, $route->getDemands());
    }

    public function testGetSetMatches()
    {
        $matches = ['id' => 1988];
        $route = $this->getInstance();
        $this->assertEquals($route, $route->setMatches($matches));
        $this->assertEquals($matches, $route->getMatches());
    }

    public function testMatchMethod()
    {
        $route = $this->getInstance();
        $route->setMethods(['POST', 'PUT']);
        $this->assertTrue($this->invokeMethod($route, 'matchMethod', ['PUT']));
        $this->assertTrue($this->invokeMethod($route, 'matchMethod', ['POST']));
        $this->assertFalse($this->invokeMethod($route, 'matchMethod', ['GET']));
    }
}