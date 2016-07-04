<?php namespace Titan\Tests\Http\Routing\Route;

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
        $this->assertTrue($route->match($uri));
        $this->assertEquals([
            'host' => ['lang' => 'en', 'country' => 'vi'],
            'path' => ['id' => 1988]
        ], $this->invokeProperty($route, 'arguments'));
    }
}