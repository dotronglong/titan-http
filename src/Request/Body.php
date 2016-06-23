<?php
namespace Titan\Http\Request;

use Titan\Common\Content\ContentAwareTrait;
use Titan\Common\Content\Parser\ParserAwareTrait;
use Titan\Common\Exception\InvalidArgumentException;
use Titan\Common\Stream\StreamAwareTrait;

class Body implements BodyInterface
{
    use ContentAwareTrait, StreamAwareTrait, ParserAwareTrait {
        getContent as private getStringContent;
    }

    /**
     * @var string
     */
    private $parsedContent;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
         return $this->getContent();
    }

    public function getContent()
    {
        if ($this->content === null && $this->getStream() !== null) {
            $this->setContent($this->getStream());
        }

        return $this->getStringContent();
    }

    /**
     * @inheritDoc
     */
    public function getParsedContent($cache = true)
    {
        if ($this->parsedContent !== null && $cache) {
            return $this->parsedContent;
        }

        if ($this->getParser() === null) {
            throw new InvalidArgumentException("There is no parsers available.");
        }

        return $this->getParser()->parse($this);
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
