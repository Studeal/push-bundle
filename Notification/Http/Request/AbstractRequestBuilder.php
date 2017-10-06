<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Http\Request;

use StudealPushBundle\Notification\Security\TokenInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class AbstractRequestBuilder
 */
abstract class AbstractRequestBuilder
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $bodyLength = 0;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    const POST = 'POST';

    /**
     * @var string
     */
    const GET = 'GET';

    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var string
     */
    const PUT = 'PUT';

    /**
     * @return $this
     */
    public function setMethodToGet()
    {
        $this->method = static::GET;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodToPost()
    {
        $this->method = static::POST;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodToDelete()
    {
        $this->method = static::DELETE;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodToPut()
    {
        $this->method = static::PUT;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setBody($data)
    {
        $this->body = json_encode($data);
        $this->bodyLength = strlen($this->body);

        return $this;
    }

    /**
     * @param TokenInterface $token
     *
     * @return $this
     */
    public function setToken(TokenInterface $token)
    {
        $this->headers['Authorization'] = $token->__toToken();

        return $this;
    }

    /**
     * @return Request
     */
    abstract public function getRequest();

    /**
     * @return $this
     */
    public function setJsonContentType()
    {
        $this->headers['Content-Type'] = 'application/json; charset=utf-8';

        return $this;
    }
}
