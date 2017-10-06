<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Http\Traits;

use StudealPushBundle\Notification\Http\HttpClientInterface;
use StudealPushBundle\Notification\Http\Request\AbstractRequestBuilder;
use StudealPushBundle\Notification\Security\TokenInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HttpHandlerTrait
 */
trait HttpHandlerTrait
{
    use LoggableTrait;

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @return HttpClientInterface
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param AbstractRequestBuilder $requestBuilder
     *
     * @return ResponseInterface
     */
    protected function send(AbstractRequestBuilder $requestBuilder)
    {
        return $this->client->send($requestBuilder->getRequest());
    }

    /**
     * @param string         $uri
     * @param TokenInterface $token
     *
     * @return ResponseInterface
     */
    protected function get($uri, TokenInterface $token)
    {
        $this->logNotice('GET request to uri: '.$uri);
        $request = $this->client->getRequestBuilder()
            ->setMethodToGet()
            ->setUri($uri)
            ->setToken($token)
            ->setJsonContentType();

        try {
            return $this->send($request);
        } catch (\RuntimeException $clientException) {
            $this->throwException($clientException);
        }
    }

    /**
     * @param string         $uri
     * @param TokenInterface $token
     * @param mixed          $body
     *
     * @return ResponseInterface
     */
    protected function post($uri, TokenInterface $token, $body = null)
    {
        $this->logNotice('POST request to uri: '.$uri);

        $request = $this->client->getRequestBuilder()
            ->setMethodToPost();

        return $this->buildRequestWithBody($request, $uri, $body, $token);
    }

    /**
     * @param string         $uri
     * @param TokenInterface $token
     * @param mixed          $body
     *
     * @return ResponseInterface
     */
    protected function put($uri, TokenInterface $token, $body = null)
    {
        $this->logNotice('PUT request to uri: '.$uri);

        $request = $this->client->getRequestBuilder()
            ->setMethodToPut();

        return $this->buildRequestWithBody($request, $uri, $body, $token);
    }

    /**
     * @param string         $uri
     * @param TokenInterface $token
     *
     * @return ResponseInterface
     */
    protected function delete($uri, TokenInterface $token)
    {
        $this->logNotice('DEL request to uri: '.$uri);
        try {
            $request = $this
                ->client
                ->getRequestBuilder()
                ->setJsonContentType()
                ->setMethodToDelete()
                ->setToken($token)
                ->setUri($uri);

            return $this->send($request);
        } catch (\RuntimeException $clientException) {
            $this->throwException($clientException);
        }
        $this->logNotice('SUCCESS');

        return new Response(500);
    }

    /**
     * @param \RuntimeException $clientException
     */
    protected function throwException(\RuntimeException $clientException)
    {
        $exceptionFromCode = static::getExceptionFromCode($clientException);
        if ($exceptionFromCode) {
            $this->logError("FAILURE ".get_class($exceptionFromCode));
            throw $exceptionFromCode;
        }

        static::clearExceptionStack();

        throw $clientException;
    }

    /**
     * @param AbstractRequestBuilder $request
     * @param string                 $uri
     * @param mixed                  $body
     * @param TokenInterface         $token
     *
     * @return ResponseInterface
     */
    private function buildRequestWithBody(AbstractRequestBuilder $request, $uri, $body, TokenInterface $token)
    {
        $request
            ->setUri($uri)
            ->setToken($token)
            ->setJsonContentType();

        if ($body) {
            $this->logNotice('With body :'.json_encode($body));
            $request->setBody($body);
        }

        try {
            $response = $this->send($request);
            $this->logNotice('SUCCESS');

            return $response;
        } catch (\RuntimeException $clientException) {
            $this->throwException($clientException);
        }
    }
}
