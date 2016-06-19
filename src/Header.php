<?php namespace Titan\Http;

use Titan\Common\BagTrait;

class Header implements HeaderInterface
{
    use BagTrait {
        has as private hasBag;
        set as private setBag;
    }

    public function has($key)
    {
        return $this->hasBag(strtolower($key));
    }

    public function set($key, $value)
    {
        $this->setBag(strtolower($key), is_array($value) ? $value : [$value]);
    }

    /**
     * @inheritDoc
     */
    public function append($key, $value)
    {
        $normalized = strtolower($key);
        $this->set($normalized, $this->get($normalized, []) + (is_array($value) ? $value : [$value]));
    }

    /**
     * @inheritDoc
     */
    public function lines()
    {
        $lines = [];
        foreach ($this->data as $key => $value) {
            $lines[] = $key . ': ' . join(', ', $value);
        }

        return $lines;
    }


}