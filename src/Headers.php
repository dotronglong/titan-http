<?php namespace Titan\Http;

use Titan\Common\Bag;
use Titan\Common\BagTrait;

class Headers extends Bag implements HeadersInterface
{
    use BagTrait {
        has as private hasBag;
        set as private setBag;
    }

    const CONTENT_TYPE = 'content-type';

    /**
     * @inheritDoc
     */
    public function append($key, $value)
    {
        $normalized = strtolower($key);
        $this->set($normalized, $this->get($normalized, []) + (is_array($value) ? $value : [$value]));
    }

    public function set($key, $value)
    {
        $this->setBag(strtolower($key), is_array($value) ? $value : [$value]);
    }

    public function has($key)
    {
        return $this->hasBag(strtolower($key));
    }

    /**
     * @inheritDoc
     */
    public function lines()
    {
        $lines = [];
        foreach ($this->data as $key => $value) {
            $lines[] = $key . ': ' . (is_array($value) ? join(', ', $value) : $value);
        }

        return $lines;
    }

    /**
     * @inheritDoc
     */
    public function flush()
    {
        foreach ($this->lines() as $line) {
            header($line);
        }
    }
}