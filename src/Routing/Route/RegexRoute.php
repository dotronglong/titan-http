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
        $o = $this->openingTag;
        $c = $this->closingTag;
        $pattern = "/\\$o(\w+)\\$c/i";

        if (preg_match_all($pattern, $subject, $matches)) {
            $replacements = [];
            foreach ($matches[1] as $i => $match) {
                $arguments[$match] = null;
                $replacement = $this->defaultReplacement;
                if (isset($demands[$match])) {
                    $replacement = $demands[$match];
                }
                $replacements[$matches[0][$i]] = "($replacement)";
            }
            $subject = str_replace(array_keys($replacements), array_values($replacements), $subject);
        }

        return $subject;
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
        $this->setUpHostArguments();
        $this->setUpPathArguments();
        if ($this->matchHostArguments($uri->getHost()) && $this->matchPathArguments($uri->getPath())) {
            return true;
        }

        return false;
    }
}