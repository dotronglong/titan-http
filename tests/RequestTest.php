<?php namespace Titan\Tests\Http;

use Titan\Http\Request;
use Titan\Http\UriInterface;
use Titan\Tests\Common\TestCase;
use Titan\Common\Content\Parser\JsonParser;
use Titan\Http\Request\FormInterface;
use Titan\Http\Request\ServerInterface;
use Titan\Http\Request\BodyInterface;
use Titan\Http\Request\CookieInterface;
use Titan\Http\Request\FilesInterface;
use Titan\Http\Request\Server;

class RequestTest extends TestCase
{
    private function getInstance()
    {
        return new Request();
    }

    public function testConstructAndGetSetMethod()
    {
        $method = 'PUT';
        $request = new Request($method);
        $this->assertEquals($method, $request->getMethod());
    }

    public function testConstructAndGetSetUri()
    {
        $uri = $this->getMockForAbstractClass(UriInterface::class);
        $request = new Request('', $uri);
        $this->assertEquals($uri, $request->getUri());
    }

    public function testConstructAndGetSetForm()
    {
        $form = $this->getMockForAbstractClass(FormInterface::class);
        $request = new Request('', null, $form);
        $this->assertEquals($form, $request->getForm());
    }

    public function testConstructAndGetSetServer()
    {
        $server = $this->getMockForAbstractClass(ServerInterface::class);
        $request = new Request('', null, null, $server);
        $this->assertEquals($server, $request->getServer());
    }

    public function testConstructAndGetSetFiles()
    {
        $files = $this->getMockForAbstractClass(FilesInterface::class);
        $request = new Request('', null, null, null, $files);
        $this->assertEquals($files, $request->getFiles());
    }

    public function testConstructAndGetSetBody()
    {
        $body = $this->getMockForAbstractClass(BodyInterface::class);
        $request = new Request('', null, null, null, null, $body);
        $this->assertEquals($body, $request->getBody());
    }

    public function testConstructAndGetSetCookie()
    {
        $cookie = $this->getMockForAbstractClass(CookieInterface::class);
        $request = new Request('', null, null, null, null, null, $cookie);
        $this->assertEquals($cookie, $request->getCookie());
    }

    public function testSetup()
    {
        $_SERVER[Server::REQUEST_METHOD] = 'PUT';
        $request = Request::setUp();

        $body = $request->getBody();
        $this->assertInstanceOf(BodyInterface::class, $body);
        $this->assertInstanceOf(JsonParser::class, $body->getParser());

        $server = $request->getServer();
        $this->assertInstanceOf(ServerInterface::class, $server);
        $this->assertEquals('PUT', $server->getRequestMethod());

        $this->assertInstanceOf(FilesInterface::class, $request->getFiles());
        $this->assertInstanceOf(FormInterface::class, $request->getForm());
        $this->assertInstanceOf(CookieInterface::class, $request->getCookie());
    }
}