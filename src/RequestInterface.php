<?php namespace Titan\Http;

use Titan\Http\Request\FormInterface;
use Titan\Http\Request\QueryInterface;

interface RequestInterface extends MessageInterface
{
    /**
     * @return QueryInterface
     */
    public function getQuery();

    /**
     * @param QueryInterface $query
     */
    public function setQuery(QueryInterface $query);

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form);
}