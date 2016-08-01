<?php namespace Titan\Tests\Http\Routing\Route;

use Titan\Http\Request;
use Titan\Http\Uri;
use Titan\Tests\Common\TestCase;
use Titan\Http\Routing\Route\RegexRoute;

class RegexRouteTest extends TestCase
{
    public function testMatch()
    {
        $host = '{lang}.domain.com.{country}';
        $path = '/account/{id}';
        $demands = [
            'lang' => '\w+',
            'country' => '[a-z]{2}',
            'id' => '\d+'
        ];
        $route = new RegexRoute('sample', $host, $path, ['GET', 'POST'], $demands);
        $uri = new Uri();
        $uri->setHost('en.domain.com.vi')
            ->setPath('/account/1988');
        $request = new Request();
        $request->setUri($uri);

        $this->assertTrue($route->match($request));
        $this->assertEquals([
            'lang' => 'en',
            'country' => 'vi',
            'id' => 1988
        ], $this->invokeProperty($route, 'matches'));
    }

    public function testMatchWithoutDemands()
    {
        $host = '{lang}.domain.com.{country}';
        $path = '/account/{id}';
        $route = new RegexRoute('sample', $host, $path, ['GET', 'POST']);
        $uri = new Uri();
        $uri->setHost('en.domain.com.vi')
            ->setPath('/account/1988');
        $request = new Request();
        $request->setUri($uri);

        $this->assertTrue($route->match($request));
        $this->assertEquals([
            'lang' => 'en',
            'country' => 'vi',
            'id' => 1988
        ], $this->invokeProperty($route, 'matches'));
    }

    public function testMatchInvalidString()
    {
        $host = '{lang}.domain.com.{country}';
        $path = '/account/{id}';
        $route = new RegexRoute('sample', $host, $path, ['GET', 'POST'], ['country' => 'us|jp']);
        $uri = new Uri();
        $uri->setHost('en.domain.com.vi')
            ->setPath('/account/1988');
        $request = new Request();
        $request->setUri($uri);

        $this->assertFalse($route->match($request));
    }
}