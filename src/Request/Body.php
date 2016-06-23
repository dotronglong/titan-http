<?php namespace Titan\Http\Request;

use Titan\Common\Content\ContentAwareTrait;
use Titan\Common\Content\Parser\ParserAwareTrait;
use Titan\Common\Exception\InvalidArgumentException;
use Titan\Common\StreamAwareTrait;

class Body implements BodyInterface
{
    use ContentAwareTrait, StreamAwareTrait, ParserAwareTrait;

    /**
     * @var string
     */
    private $parsedContent;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $content = '';
        if ($this->getStream() !== null) {
            $content = $this->getStream();
        } elseif ($this->getContent() !== null) {
            $content = $this->getContent();
        }

        return (string) $content;
    }

    /**
     * @inheritDoc
     */
    public function getParsedContent()
    {
        if ($this->parsedContent !== null) {
            return $this->parsedContent;
        }

        if ($this->getParser() === null) {
            throw new InvalidArgumentException("There is no parsers available.");
        }

        return $this->getParser()->parse($this->getContent());
    }

    /**
     * @inheritDoc
     */
    public function setParsedContent($parsedContent)
    {
        $this->parsedContent = $parsedContent;

        return $this;
    }
}
