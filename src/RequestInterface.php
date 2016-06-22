<?php namespace Titan\Http;

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
}
