<?php namespace Titan\Http;

use Titan\Http\Request\BodyInterface;
use Titan\Http\Request\CookieInterface;
use Titan\Http\Request\FilesInterface;
use Titan\Http\Request\FormInterface;
use Titan\Http\Request\ServerInterface;

interface RequestInterface extends MessageInterface
{
    const METHOD_GET     = 'GET';
    const METHOD_PUT     = 'PUT';
    const METHOD_POST    = 'POST';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @return UriInterface
     */
    public function getUri();

    /**
     * @param UriInterface $uri
     * @return self
     */
    public function setUri(UriInterface $uri);

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setForm(FormInterface $form);

    /**
     * @return ServerInterface
     */
    public function getServer();

    /**
     * @param ServerInterface $server
     * @return self
     */
    public function setServer(ServerInterface $server);

    /**
     * @return FilesInterface
     */
    public function getFiles();

    /**
     * @param FilesInterface $files
     * @return self
     */
    public function setFiles(FilesInterface $files);

    /**
     * @return CookieInterface
     */
    public function getCookie();

    /**
     * @param CookieInterface $cookie
     * @return self
     */
    public function setCookie(CookieInterface $cookie);

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod();

    /**
     * Set request method
     *
     * @param string $method
     * @return self
     */
    public function setMethod($method);

    /**
     * @return BodyInterface
     */
    public function getBody();

    /**
     * @param BodyInterface $body
     * @return self
     */
    public function setBody(BodyInterface $body);
}
