<?php namespace Titan\Tests\Http\Routing\Route;

use Titan\Tests\Common\TestCase;
use Titan\Http\Routing\Route\RegexRoute;

class RegexRouteTest extends TestCase
{
    public function testReplaceTags()
    {
        $route = new RegexRoute();
        $string = '{lang}.domain.com.{country}';
        $tags = [
            'lang' => '\w+',
            'country' => '[a-z]{2}'
        ];
        $expected = "({$tags['lang']}).domain.com.({$tags['country']})";
        $this->assertEquals($expected, $this->invokeMethod($route, 'replaceTags', [$string, $tags]));
    }
}