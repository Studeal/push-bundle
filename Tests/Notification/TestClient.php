<?php

namespace Tests\Notification;


use StudealPushBundle\Notification\Http\HttpClientInterface;
use StudealPushBundle\Notification\Http\Request\GuzzleRequestBuilder;
use StudealPushBundle\Notification\Http\Request\AbstractRequestBuilder;
use GuzzleHttp\Client;

class TestClient extends Client implements HttpClientInterface
{
    /**
     * GuzzleHttpClient constructor.
     * @param string $baseUri
     */
    public function __construct($handler)
    {
        parent::__construct(array('handler' => $handler));
    }

    /**
     * @return AbstractRequestBuilder
     */
    public function getRequestBuilder()
    {
        return new GuzzleRequestBuilder();
    }
}