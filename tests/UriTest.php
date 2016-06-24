<?php namespace Titan\Tests\Http;

use Titan\Http\Uri;
use Titan\Tests\Common\TestCase;

class UriTest extends TestCase
{
    private $sampleUrl = 'http://dotronglong:123456@github.com:80/titan-http.git?a=5&c=7#b=6';

    public function testCreateUriFromUrl()
    {
        $uri = new Uri($this->sampleUrl);
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('dotronglong:123456', $uri->getUserInfo());
        $this->assertEquals('github.com', $uri->getHost());
        $this->assertEquals('/titan-http.git', $uri->getPath());
        $this->assertEquals(['a' => 5, 'c' => 7], $uri->getQuery()->all());
        $this->assertEquals('b=6', $uri->getFragment());
        $this->assertEquals(80, $uri->getPort());
        $this->assertEmpty($uri->getBaseUrl());
        $this->assertEquals('dotronglong:123456@github.com:80', $uri->getAuthority());
    }

    public function testBaseUrlAndPath()
    {
        $uri = new Uri();
        $uri->setBaseUrl('/folder/');
        $uri->setPath('/folder/my-path');
        $this->assertEquals('/my-path', $uri->getPath());
        $this->assertEquals('/folder', $uri->getBaseUrl());
    }
}
