<?php namespace Titan\Http;

interface ResponseInterface extends MessageInterface
{
    /**
     * Send out all of contents, headers
     */
    public function send();
}