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

    /**
     * @var array
     */
    protected $patterns = [
        self::ROUTE_HOST => '',
        self::ROUTE_PATH => ''
    ];

    protected function setUpArguments($subject, array $demands, &$arguments)
    {
        $pattern = "/\\{$this->openingTag}\w+\\{$this->closingTag}/i";
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
            $pattern = $this->setUpArguments($this->host, $this->demands, $this->arguments[static::ROUTE_HOST]);
            $this->patterns[static::ROUTE_HOST] = $this->cleanUpPattern($pattern);
        }
    }

    private function setUpPathArguments()
    {
        if ($this->path) {
            $pattern = $this->setUpArguments($this->path, $this->demands, $this->arguments[static::ROUTE_PATH]);
            $this->patterns[static::ROUTE_PATH] = $this->cleanUpPattern($pattern);
        }
    }

    protected function cleanUpPattern($pattern)
    {
        return str_replace(['/'], ['\/'], $pattern);
    }

    protected function matchArguments($pattern, $subject, array &$arguments)
    {
        if (preg_match("/$pattern/i", $subject, $matches)) {
            $i = 1;
            foreach ($arguments as $name => $value) {
                $arguments[$name] = isset($matches[$i]) ? $matches[$i] : null;
                $i++;
            }

            return true;
        }

        return false;
    }

    private function matchHostArguments($host)
    {
        return $this->matchArguments($this->patterns[static::ROUTE_HOST], $host, $this->arguments[static::ROUTE_HOST]);
    }

    private function matchPathArguments($path)
    {
        return $this->matchArguments($this->patterns[static::ROUTE_PATH], $path, $this->arguments[static::ROUTE_PATH]);
    }

    public function match(UriInterface $uri)
    {
        if (count($this->demands)) {
            $this->setUpHostArguments();
            $this->setUpPathArguments();
        }

        if ($this->matchHostArguments($uri->getHost()) && $this->matchPathArguments($uri->getPath())) {
            return true;
        }

        return false;
    }
}