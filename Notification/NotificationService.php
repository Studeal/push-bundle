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
class NotificationService implements NotificationClientInterface
{
    use ExceptionHandlerTrait, HttpHandlerTrait;

    /**
     * BaseService constructor.
     * @param HttpClientInterface $client
     * @param LoggerInterface     $logger
     */
    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->setLogger($logger);
    }


    /**
     * https://onesignal.com/api/v1/notifications/:id?app_id=:app_id
     *
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     */
    public function cancelNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        $notificationId = $message->getNotificationId();
        $appId = $message->getAppId();

        $uri = "/api/v1/notifications/$notificationId?app_id=$appId";

        return $this->delete($uri, $token);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     *
     * https://onesignal.com/api/v1/notifications
     {
        "app_id": "5eb5a37e-b458-11e3-ac11-000c2940e62c",
        "contents": {
            "en": "English Message"
        },
        "data": {
            "postId": "1454",
            "associationId": "3"
        },
        "include_player_ids": [
            "6392d91a-b206-4b7b-a620-cd68e32c3a76",
            "76ece62b-bcfe-468c-8a78-839aeaa8c5fa",
            "8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86",
            "5fdc92b2-3b2a-11e5-ac13-8fdccfe4d986",
            "00cb73f8-5815-11e5-ba69-f75522da5528"
        ]
     }
     */
    public function sendNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        static::registerNotificationException();
        $uri = "/api/v1/notifications";
        $body = $message->toRequest();

        return $this->post($uri, $token, $body);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return ResponseInterface
     *
     * https://onesignal.com/api/v1/notifications/{notificationId}?app_id={appId}
     */
    public function getNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        $notificationId = $message->getNotificationId();
        $appId = $message->getAppId();

        $uri = "/api/v1/notifications/$notificationId?app_id=$appId";

        return $this->get($uri, $token);
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     * @param int                          $limit
     * @param int                          $offset
     *
     * @return ResponseInterface
     *
     * https://onesignal.com/api/v1/notifications?app_id={appId}&limit={limit}&offset={offset}
     */
    public function listNotifications(NotificationMessageInterface $message, TokenInterface $token, $limit = 50, $offset = 0)
    {
        $appId = $message->getAppId();

        $uri = "/api/v1/notifications?app_id=$appId&limit=$limit&offset=$offset";

        return $this->get($uri, $token);
    }
}
