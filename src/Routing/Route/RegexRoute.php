<?php namespace Titan\Http\Routing\Route;

use Titan\Http\RequestInterface;
use Titan\Http\Routing\Route;

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
     * @var string
     */
    private $reservedHost;

    /**
     * @var string
     */
    private $reservedPath;

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

    /**
     * Performs cleanUp process to assure return value is a valid regexp string
     *
     * @param string $pattern
     * @return string
     */
    protected function cleanUpPattern($pattern)
    {
        return str_replace(['/'], ['\/'], $pattern);
    }

    /**
     * Do pre-check by scanning and replacing arguments in proposed subject with appropriate pattern
     *
     * @param string $subject
     * @param array  $demands
     * @param array  $arguments
     * @return string
     */
    protected function setUpArguments($subject, array $demands, &$arguments)
    {
        $o       = $this->openingTag;
        $c       = $this->closingTag;
        $pattern = "/\\$o(\w+)\\$c/i";

        if (preg_match_all($pattern, $subject, $matches)) {
            $replacements = [];
            foreach ($matches[1] as $i => $match) {
                $arguments[$match] = null;
                $replacement       = $this->defaultReplacement;
                if (isset($demands[$match])) {
                    $replacement = $demands[$match];
                }
                $replacements[$matches[0][$i]] = "($replacement)";
            }
            $subject = str_replace(array_keys($replacements), array_values($replacements), $subject);
        }

        return $this->cleanUpPattern($subject);
    }

    /**
     * Defines whether the provided subject matches the pattern or not,
     * it also changes the proposed arguments list
     *
     * @param string $pattern
     * @param string $subject
     * @param array  $arguments
     * @return bool
     */
    protected function matchArguments($pattern, $subject, array &$arguments)
    {
        if (preg_match("/^$pattern$/i", $subject, $matches)) {
            $i = 1;
            foreach ($arguments as $name => $value) {
                $arguments[$name] = isset($matches[$i]) ? $matches[$i] : null;
                $i++;
            }

            return true;
        }

        return false;
    }

    private function matchHost($host)
    {
        return $this->matchArguments($this->host, $host, $this->arguments[static::ROUTE_HOST]);
    }

    private function matchPath($path)
    {
        return $this->matchArguments($this->path, $path, $this->arguments[static::ROUTE_PATH]);
    }

    public function match(RequestInterface $request)
    {
        $this->preMatch();

        /* In case to improve? Return false immediately whenever a match fails */
        $isHostMatched   = $this->matchHost($request->getUri()->getHost());
        $isPathMatched   = $this->matchPath($request->getUri()->getPath());
        $isMethodMatched = $this->matchMethod($request->getMethod());

        $this->postMatch();

        return $isHostMatched && $isPathMatched && $isMethodMatched;
    }

    protected function preMatch()
    {
        $this->reservedHost = $this->host;
        $this->reservedPath = $this->path;

        $this->host = $this->setUpArguments($this->host, $this->demands, $this->arguments[static::ROUTE_HOST]);
        $this->path = $this->setUpArguments($this->path, $this->demands, $this->arguments[static::ROUTE_PATH]);
    }

    protected function postMatch()
    {
        $this->host = $this->reservedHost;
        $this->path = $this->reservedPath;

        $this->reservedHost = null;
        $this->reservedPath = null;

        $this->matches = array_merge(
            $this->arguments[static::ROUTE_HOST],
            $this->arguments[static::ROUTE_PATH]
        );
    }
}