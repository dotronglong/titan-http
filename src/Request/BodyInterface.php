<?php namespace Titan\Http\Request;

use Titan\Common\Content\ContentAwareInterface;
use Titan\Common\Content\Parser\ParserAwareInterface;
use Titan\Common\Exception\InvalidArgumentException;
use Titan\Common\Stream\StreamAwareInterface;
use Titan\Common\Stringable;

interface BodyInterface extends ContentAwareInterface, StreamAwareInterface, ParserAwareInterface, Stringable
{
    /**
     * Parse and return parsed content
     *
     * @param bool $cache Only parse one time, and get cache result if this setting is true, run parsing if otherwise
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getParsedContent($cache = true);

    /**
     * Set parsed content
     *
     * @param string $parsedContent
     * @return self
     */
    public function setParsedContent($parsedContent);
}
