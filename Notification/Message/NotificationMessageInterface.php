<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Message;

/**
 * Interface NotificationMessageInterface
 */
interface NotificationMessageInterface
{

    /**
     * @return string
     */
    public function getAppId();

    /**
     * @return string
     */
    public function getNotificationId();

    /**
     * @return array
     */
    public function getDeviceIdList();

    /**
     * @param array $ids
     *
     * @return NotificationMessageInterface
     */
    public function setDeviceIdList(array $ids = []);

    /**
     * @return array
     */
    public function getAttachment();

    /**
     * @param array $attachment
     *
     * @return NotificationMessageInterface
     */
    public function setAttachment(array $attachment = null);

    /**
     * @return string
     */
    public function getAttachmentKey();

    /**
     * @return array
     */
    public function getContent();

    /**
     * @param array $title
     *
     * @return NotificationMessageInterface
     */
    public function setTitle(array $title = null);

    /**
     * @return array
     */
    public function getTitle();

    /**
     * @param array $content
     *
     * @return NotificationMessageInterface
     */
    public function setContent(array $content = null);

    /**
     * @return array
     */
    public function getExtraData();

    /**
     * @return array
     */
    public function toRequest();
}
