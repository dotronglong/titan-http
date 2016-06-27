<?php namespace Titan\Http\Routing\Route;

use Titan\Http\Routing\Route;
use Titan\Http\UriInterface;

class RegexRoute extends Route
{
    /**
     * @var string
     */
    protected $type = 'regex';

    /**
     * @var string
     */
    protected $openingTag = '{';

    /**
     * @var string
     */
    protected $closingTag = '}';

    /**
     * @var string
     */
    protected $defaultReplacement = '\w+';

    /**
     * @var array
     */
    protected $arguments = [
        self::ROUTE_HOST => [],
        self::ROUTE_PATH => []
    ];

    protected function setUpArguments($subject, array $demands, &$arguments)
    {
        $pattern          = "/\\{$this->openingTag}\w+\\{$this->closingTag}/i";
        $openingTagLength = strlen($this->openingTag);
        $closingTagLength = strlen($this->closingTag);

        return preg_replace_callback($pattern,
            function ($matches) use ($openingTagLength, $closingTagLength, $demands, &$arguments) {
                $match = substr($matches[0], $openingTagLength, strlen($matches[0]) - $closingTagLength - 1);

                $arguments[$match] = null;
                if (array_key_exists($match, $demands)) {
                    return "({$demands[$match]})";
                } else {
                    return "({$this->defaultReplacement})";
                }
            }, $subject);
    }

    private function setUpHostArguments()
    {
        if ($this->host) {
            $this->setHost($this->setUpArguments($this->host, $this->demands, $this->arguments[static::ROUTE_HOST]));
        }
    }

    private function setUpPathArguments()
    {
        if ($this->path) {
            $this->setPath($this->setUpArguments($this->path, $this->demands, $this->arguments[static::ROUTE_PATH]));
        }
    }

    protected function matchArguments($pattern, $subject, array $arguments)
    {

    }

    private function matchHostArguments()
    {

    }

    private function matchPathArguments()
    {

    }

    public function match(UriInterface $uri)
    {
        if (count($this->demands)) {
            $this->setUpHostArguments();
            $this->setUpPathArguments();
        }

        if ($this->matchHostArguments() && $this->matchPathArguments()) {
            return true;
        }

        return false;
    }
}