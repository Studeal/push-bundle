<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Provider\Firebase;

use StudealPushBundle\Exception\ActionDoesNotExistsException;
use StudealPushBundle\Notification\AbstractNotificationService;
use StudealPushBundle\Notification\Message\NotificationMessageInterface;
use StudealPushBundle\Notification\Security\TokenInterface;

/**
 * Class FirebaseNotificationService
 */
class FirebaseNotificationService extends AbstractNotificationService
{
    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface $token
     * @throws ActionDoesNotExistsException
     */
    public function cancelNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        throw new ActionDoesNotExistsException();
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface $token
     * @throws ActionDoesNotExistsException
     */
    public function getNotification(NotificationMessageInterface $message, TokenInterface $token)
    {
        throw new ActionDoesNotExistsException();
    }

    /**
     * @param NotificationMessageInterface $message
     * @param TokenInterface $token
     * @param int $limit
     * @param int $offset
     * @throws ActionDoesNotExistsException
     */
    public function listNotifications(NotificationMessageInterface $message, TokenInterface $token, $limit = 50, $offset = 0)
    {
        throw new ActionDoesNotExistsException();
    }


}