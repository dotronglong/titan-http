<?php namespace Titan\Http;

use Titan\Http\Request\FormInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @type UriInterface
     */
    private $uri;

    /**
     * @type FormInterface
     */
    private $form;

    public function getUri()
    {
        return $this->uri;
    }

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
}
