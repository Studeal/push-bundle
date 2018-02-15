<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StudealPushBundle\Notification\Http;

use StudealPushBundle\Notification\Http\Request\AbstractRequestBuilder;
use StudealPushBundle\Notification\Http\Request\GuzzleRequestBuilder;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient extends \GuzzleHttp\Client implements HttpClientInterface
{
    /**
     * GuzzleHttpClient constructor.
     *
     * @param string $baseUri
     */
    public function __construct($baseUri)
    {
        parent::__construct(['base_uri' => $baseUri]);
    }

    /**
     * @return AbstractRequestBuilder
     */
    public function getRequestBuilder()
    {
        return new GuzzleRequestBuilder();
    }
}
