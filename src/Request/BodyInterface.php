<?php namespace Titan\Http\Request;

use Titan\Common\Content\ContentAwareInterface;
use Titan\Common\Content\Parser\ParserAwareInterface;
use Titan\Common\Exception\InvalidArgumentException;
use Titan\Common\Stream\StreamAwareInterface;

interface BodyInterface extends ContentAwareInterface, StreamAwareInterface, ParserAwareInterface
{
    /**
     * Return the content of body as string
     *
     * @return string
     */
    public function __toString();

    /**
     * Parse and return parsed content
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getParsedContent();

    /**
     * Set parsed content
     *
     * @param string $parsedContent
     * @return self
     */
    public function setParsedContent($parsedContent);
}
