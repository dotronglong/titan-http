<?php namespace Titan\Http;

use Titan\Common\Content\ContentAwareInterface;
use Titan\Http\Exception\InvalidArgumentException;

interface ResponseInterface extends MessageInterface, ContentAwareInterface
{
    /**
     * Send out all of contents, headers
     *
     * @throws InvalidArgumentException
     */
    public function send();
}