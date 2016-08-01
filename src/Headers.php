<?php namespace Titan\Http;

use Titan\Common\Str;
use Titan\Common\Bag;
use Titan\Common\BagTrait;

class Headers extends Bag implements HeadersInterface
{
    use BagTrait {
        has as private hasBag;
        set as private setBag;
        get as private getBag;
    }
    const CONTENT_TYPE = 'content-type';

    /**
     * @inheritDoc
     */
    public function append($key, $value)
    {
        $normalized = strtolower($key);
        $oldValues  = $this->getBag($normalized, []);
        $newValues  = is_array($value) ? $value : [$value];

        $this->setBag($normalized, array_merge($oldValues, $newValues));
    }

    public function get($key, $default = null)
    {
        $normalized = strtolower($key);

        return $this->hasBag($normalized) ? $this->getBag($normalized) : $default;
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
            $lines[] = Str::upperCaseFirst($key, '-') . ': ' . (is_array($value) ? join(', ', $value) : $value);
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

        $this->clean();
    }
}