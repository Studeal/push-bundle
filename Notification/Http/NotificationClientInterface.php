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

use GuzzleHttp\Psr7\Response;
use StudealPushBundle\Notification\Message\NotificationMessageInterface;
use StudealPushBundle\Notification\Security\TokenInterface;

/**
 * Interface NotificationClientInterface.
 */
interface NotificationClientInterface
{
    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return Response
     */
    public function cancelNotification(NotificationMessageInterface $message, TokenInterface $token);

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return Response
     */
    public function sendNotification(NotificationMessageInterface $message, TokenInterface $token);

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     *
     * @return Response
     */
    public function getNotification(NotificationMessageInterface $message, TokenInterface $token);

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface               $token
     * @param int                          $limit
     * @param int                          $offset
     *
     * @return Response
     */
    public function listNotifications(NotificationMessageInterface $message, TokenInterface $token, $limit = 50, $offset = 0);
}
