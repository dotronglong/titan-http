<?php namespace Titan\Http;

use Titan\Http\Request\CookieInterface;
use Titan\Http\Request\FilesInterface;
use Titan\Http\Request\FormInterface;
use Titan\Http\Request\ServerInterface;

interface RequestInterface extends MessageInterface
{
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
}
