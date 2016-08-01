<?php namespace Titan\Http\Routing;

use Titan\Http\Exception\InvalidArgumentException;
use Titan\Http\Request;

abstract class Route implements RouteInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var array
     */
    protected $demands = [];

    /**
     * @var array
     */
    protected $matches = [];

    public function __construct(
        $name = null,
        $host = null,
        $path = null,
        array $methods = [],
        array $demands = [],
        array $matches = []
    ) {
        $this->setName($name)
            ->setHost($host)
            ->setPath($path)
            ->setMethods($methods)
            ->setDemands($demands)
            ->setMatches($matches);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        if ($host !== null && !is_string($host)) {
            throw new InvalidArgumentException('Host of route must be a string or null.');
        }
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        if ($path !== null && !is_string($path)) {
            throw new InvalidArgumentException('Path of route must be a string or null.');
        }
        $this->path = $path;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @return array
     */
    public function getDemands()
    {
        return $this->demands;
    }

    /**
     * @param array $demands
     */
    public function setDemands(array $demands)
    {
        $this->demands = $demands;

        return $this;
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param array $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;

        return $this;
    }

    protected function matchMethod($method)
    {
        return in_array($method, $this->methods);
    }
}