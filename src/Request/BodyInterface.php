<?php namespace Titan\Http\Request;

interface BodyInterface
{
    /**
     * Return the content of body as string
     *
     * @return string
     */
    public function __toString();
}
