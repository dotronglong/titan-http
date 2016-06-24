<?php namespace Titan\Http\Routing\Route;

use Titan\Http\Routing\Route;
use Titan\Http\UriInterface;

class RegexRoute extends Route
{
    /**
     * @var string
     */
    private $type = 'regex';

    /**
     * @var string
     */
    protected $openingTag = '{';

    /**
     * @var string
     */
    protected $closingTag = '}';

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * Prepare information of route
     */
    protected function prepare()
    {
        $host = $this->getHost();
        $path = $this->getPath();
        $demands = $this->getDemands();
        if (count($demands)) {
            if ($host !== null) {
                $this->setHost($this->replaceTags($host, $demands));
            }
            if ($path !== null) {
                $this->setPath($this->replaceTags($path, $demands));
            }
        }
    }

    protected function replaceTags($string, $tags)
    {
        $pattern          = "/\\{$this->openingTag}\w+\\{$this->closingTag}/i";
        $openingTagLength = strlen($this->openingTag);
        $closingTagLength = strlen($this->closingTag);

        return preg_replace_callback($pattern, function ($matches) use ($openingTagLength, $closingTagLength, $tags) {
            $match = substr($matches[0], $openingTagLength, strlen($matches[0]) - $closingTagLength - 1);
            if (array_key_exists($match, $tags)) {
                return "({$tags[$match]})";
            }

            return $match;
        }, $string);
    }

    public function match(UriInterface $uri)
    {
        $host = $this->getHost();
        $path = $this->getPath();
    }
}