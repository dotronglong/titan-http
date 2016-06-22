<?php namespace Titan\Http;

use Titan\Http\Request\Query;
use Titan\Http\Request\QueryInterface;

class Uri implements UriInterface
{
    const URI_SCHEME   = 'scheme';
    const URI_HOST     = 'host';
    const URI_PORT     = 'port';
    const URI_USER     = 'user';
    const URI_PASS     = 'pass';
    const URI_PATH     = 'path';
    const URI_QUERY    = 'query';
    const URI_FRAGMENT = 'fragment';

    /**
     * @var array
     */
    private $supportedSchemes = [
        self::SCHEME_HTTP  => 80,
        self::SCHEME_HTTPS => 443,
    ];

    /**
     * @var string
     */
    protected $charUnreserved = 'a-zA-Z0-9_\-\.~';

    /**
     * @var string
     */
    protected $charSubDelims = '!\$&\'\(\)\*\+,;=';

    /**
     * @var array
     */
    protected $replaceQuery = ['=' => '%3D', '&' => '%26'];

    /**
     * @var string
     */
    protected $scheme = '';

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $fragment = '';

    /**
     * @var QueryInterface
     */
    protected $query;

    /**
     * @var string
     */
    protected $userInfo = '';

    /**
     * @var string
     */
    protected $baseUrl = '';

    public function __construct($options = [])
    {
        if (is_array($options)) {
            $this->createUriFromArray($options);
        } elseif (is_string($options)) {
            $this->createUriFromUrl($options);
        }
    }

    private function createUriFromArray(array $parts)
    {
        if (isset($parts[static::URI_SCHEME])) {
            $this->setScheme($parts[static::URI_SCHEME]);
        }
        if (isset($parts[static::URI_HOST])) {
            $this->setHost($parts[static::URI_HOST]);
        }
        if (isset($parts[static::URI_PORT])) {
            $this->setPort($parts[static::URI_PORT]);
        }
        if (isset($parts[static::URI_USER])) {
            $user     = $parts[static::URI_USER];
            $password = null;
            if (isset($parts[static::URI_PASS])) {
                $password = $parts[static::URI_PASS];
            }
            $this->setUserInfo($user, $password);
        }
        if (isset($parts[static::URI_PATH])) {
            $this->setPath($parts[static::URI_PATH]);
        }
        if (isset($parts[static::URI_FRAGMENT])) {
            $this->setFragment($parts[static::URI_FRAGMENT]);
        }
        if (isset($parts[static::URI_QUERY])) {
            $this->setQuery(new Query($parts[static::URI_QUERY]));
        }
    }

    private function createUriFromUrl($url)
    {
        if (($parts = parse_url($url)) === false) {
            throw new \InvalidArgumentException("Unable to parse url: $url");
        }

        $this->createUriFromArray($parts);
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {
        $authority = '';
        if (!empty($this->host)) {
            $authority = $this->host;
            if (!empty($this->userInfo)) {
                $authority = "{$this->userInfo}@$authority";
            }

            if ($this->port !== null) {
                $authority = "$authority:{$this->port}";
            }
        }

        return $authority;
    }

    /**
     * @inheritDoc
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @inheritDoc
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFragment($fragment)
    {
        if (!is_string($fragment)) {
            throw new \InvalidArgumentException('Query and fragment must be a string');
        }

        $this->fragment = preg_replace_callback(
            '/(?:[^' . $this->charUnreserved . $this->charSubDelims . '%:@\/\?]++|%(?![A-Fa-f0-9]{2}))/',
            [$this, 'rawUrlEncodeMatchZero'],
            $fragment
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setHost($host)
    {
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Host must be a string');
        }
        $this->host = strtolower($host);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('Path must be a string');
        }

        $this->path = preg_replace_callback(
            '/(?:[^' . $this->charUnreserved . $this->charSubDelims . '%:@\/]++|%(?![A-Fa-f0-9]{2}))/',
            [$this, 'rawUrlEncodeMatchZero'],
            $path
        );
    }

    /**
     * @inheritDoc
     */
    public function setPort($port)
    {
        if ($port === null) {
            return null;
        }

        $port = (int) $port;
        if (1 > $port || 0xffff < $port) {
            throw new \InvalidArgumentException(
                sprintf('Invalid port: %d. Must be between 1 and 65535', $port)
            );
        }
        $this->port = $this->isStandardPort($this->scheme, $port) ? $port : null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setScheme($scheme = self::SCHEME_HTTP)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Scheme must be a string');
        }
        $this->scheme = strtolower($scheme);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUserInfo($user, $password = null)
    {
        if (is_string($password) && !empty($password)) {
            $this->userInfo = "$user:$password";
        } else {
            $this->userInfo = $user;
        }

        return $this;
    }

    /**
     * Is a given port non-standard for the current scheme?
     *
     * @param string $scheme
     * @param int $port
     *
     * @return bool
     */
    private function isStandardPort($scheme, $port)
    {
        return isset($this->supportedSchemes[$scheme]) && $port === $this->supportedSchemes[$scheme];
    }

    private function rawUrlEncodeMatchZero(array $match)
    {
        return rawurlencode($match[0]);
    }
}
