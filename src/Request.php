<?php namespace Titan\Http;

use Titan\Common\Stream;
use Titan\Http\Request\Body;
use Titan\Http\Request\BodyInterface;
use Titan\Http\Request\Cookie;
use Titan\Http\Request\CookieInterface;
use Titan\Http\Request\Files;
use Titan\Http\Request\FilesInterface;
use Titan\Http\Request\Form;
use Titan\Http\Request\FormInterface;
use Titan\Http\Request\Server;
use Titan\Http\Request\ServerInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @var BodyInterface
     */
    private $body;

    /**
     * @var CookieInterface
     */
    private $cookie;

    /**
     * @var FilesInterface
     */
    private $files;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var string
     */
    private $method = self::METHOD_GET;

    /**
     * @var ServerInterface
     */
    private $server;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @return RequestInterface
     */
    public static function setUp()
    {
        $body = new Body();
        $body->setStream(new Stream(Stream::PHP_INPUT));

        $request = new self;
        $request->setServer(new Server($_SERVER))
            ->setUri(new Uri($request->getServer()->getRequestUri()))
            ->setCookie(new Cookie())
            ->setFiles(new Files())
            ->setForm(new Form())
            ->setBody($body);

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function setBody(BodyInterface $body)
    {
        $this->body = $body;
    }

    /**
     * @inheritDoc
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @inheritDoc
     */
    public function setCookie(CookieInterface $cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @inheritDoc
     */
    public function setFiles(FilesInterface $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @inheritDoc
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @inheritDoc
     */
    public function setServer(ServerInterface $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function setUri(UriInterface $uri)
    {
        $this->uri = $uri;

        return $this;
    }
}
