<?php namespace Titan\Http;

use Titan\Common\Content\ContentAwareTrait;
use Titan\Http\Exception\InvalidArgumentException;

class Response extends Message implements ResponseInterface
{
    use ContentAwareTrait;

    /**
     * @var string
     */
    protected $contentType = self::CONTENT_TYPE_HTML;

    public function __construct(HeadersInterface $headers = null)
    {
        if ($headers === null) {
            $headers = new Headers([
                Headers::CONTENT_TYPE => $this->contentType
            ]);
        }
        $this->setHeaders($headers);
    }

    /**
     * @inheritDoc
     */
    public function send()
    {
        // Flush all header
        $this->getHeaders()->flush();

        // Send all content
        $content = $this->getContent();
        if (is_string($content)) {
            echo $content;
        } else {
            throw new InvalidArgumentException('Content must be a string.');
        }
    }
}