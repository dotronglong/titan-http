<?php namespace Titan\Http\Request;

use Titan\Common\BagTrait;

class Query implements QueryInterface
{
    use BagTrait;

    const QUERY_AND   = '&';
    const QUERY_EQUAL = '=';

    public function __construct($query)
    {
        if (is_array($query)) {
            $this->replace($query);
        } elseif (is_string($query)) {
            $this->importQueryString($query);
        }
    }

    private function importQueryString($query)
    {
        $data = [];
        $args = explode(static::QUERY_AND, $query);
        if (count($args) > 1) {
            foreach ($args as $arg) {
                $pair = explode(static::QUERY_EQUAL, $arg);
                if (count($pair) === 2) {
                    $data[$pair[0]] = $pair[1];
                }
            }
        }
        if (count($data)) {
            $this->replace($data);
        }
    }
}
