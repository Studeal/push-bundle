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

use GuzzleHttp\Psr7\Request;

/**
 * Class GuzzleRequestBuilder
 */
class GuzzleRequestBuilder extends AbstractRequestBuilder
{
    /**
     * @return Request
     */
    public function getRequest()
    {
        $request = new Request($this->method, $this->uri, $this->headers, $this->body);
        $this->method = null;
        $this->uri = null;
        $this->headers = [];
        $this->body = null;

        return $request;
    }
}
