<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification;

use StudealPushBundle\Notification\Exception\ExceptionHandlerTrait;
use StudealPushBundle\Notification\Http\HttpClientInterface;
use StudealPushBundle\Notification\Http\NotificationClientInterface;
use StudealPushBundle\Notification\Http\Traits\HttpHandlerTrait;
use StudealPushBundle\Notification\Message\NotificationMessageInterface;
use StudealPushBundle\Notification\Security\TokenInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class NotificationService
 */
abstract class AbstractNotificationService implements NotificationClientInterface
{
    use ExceptionHandlerTrait, HttpHandlerTrait;

    /**
     * BaseService constructor.
     * @param HttpClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(HttpClientInterface $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->setLogger($logger);
    }


    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     */
    public function cancelNotification(NotificationMessageInterface $message, TokenInterface $token)
    {

        return $this->delete($message->toRoute(), $token);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     */
    public function sendNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        static::registerNotificationException();
        $body = $message->toRequest();

        return $this->post($message->toRoute(), $token, $body);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     */
    public function getNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        return $this->get($message->toRoute(), $token);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     * @param int                          $limit
     * @param int                          $offset
     *
     * @return ResponseInterface
     */
    public function listNotifications(NotificationMessageInterface $message, TokenInterface $token, $limit = 50, $offset = 0)
    {

        return $this->get($message->toRoute().'&limit='.$limit.'&offset='.$offset, $token);
    }
}
