<?php namespace Titan\Http\Response;

use Titan\Http\Exception\InvalidArgumentException;
use Titan\Http\Response;

class JsonResponse extends Response
{
    /**
     * @var string
     */
    protected $contentType = self::CONTENT_TYPE_JSON;

    public function send()
    {
        $content = $this->getContent();
        if (is_resource($content)) {
            throw new InvalidArgumentException('Content of JsonResponse must not be a resource');
        }

        $content = json_encode($content);
        if ($content === false) {
            throw new InvalidArgumentException('Unable to encode content into JSON string.');
        } else {
            $this->setContent($content);
        }

        return parent::send();
    }
}