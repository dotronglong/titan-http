<?php namespace Titan\Http;

use Titan\Http\Request\FormInterface;
use Titan\Http\Request\QueryInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @type QueryInterface
     */
    private $query;

    /**
     * @type FormInterface
     */
    private $form;

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;
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
    }
}