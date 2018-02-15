<?php

namespace Tests\Notification;

use GuzzleHttp\Client;
use StudealPushBundle\Notification\Http\HttpClientInterface;
use StudealPushBundle\Notification\Http\Request\AbstractRequestBuilder;
use StudealPushBundle\Notification\Http\Request\GuzzleRequestBuilder;

class TestClient extends Client implements HttpClientInterface
{
    /**
     * GuzzleHttpClient constructor.
     *
     * @param $handler
     */
    public function __construct($handler)
    {
        parent::__construct(['handler' => $handler]);
    }

    /**
     * @return AbstractRequestBuilder
     */
    public function getRequestBuilder()
    {
        return new GuzzleRequestBuilder();
    }
}
