<?php namespace Titan\Http;

use Titan\Http\Request\CookieInterface;
use Titan\Http\Request\FilesInterface;
use Titan\Http\Request\FormInterface;
use Titan\Http\Request\ServerInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var ServerInterface
     */
    private $server;

    /**
     * @var CookieInterface
     */
    private $cookie;

    /**
     * @var FilesInterface
     */
    private $files;

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

    public static function setUp()
    {

    }
}
