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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use StudealPushBundle\Notification\Http\Request\AbstractRequestBuilder;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
    /**
     * @return AbstractRequestBuilder
     */
    public function getRequestBuilder();

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request);
}
