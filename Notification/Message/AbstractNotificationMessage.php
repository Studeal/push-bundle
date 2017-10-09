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
 * Class NotificationMessage
 */
abstract class AbstractNotificationMessage implements NotificationMessageInterface
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $notificationId;

    /**
     * @var array
     */
    protected $title;

    /**
     * @var array
     */
    protected $devices;

    /**
     * @var array
     */
    protected $attachment;

    /**
     * @var array
     */
    protected $content;

    /**
     * NotificationMessage constructor.
     * @param string $appId
     * @param string $notificationId
     */
    public function __construct($appId, $notificationId = null)
    {
        $this->appId = $appId;
        $this->notificationId = $notificationId;
        $this->devices = [];
        $this->attachment = [];
        $this->content = [];
        $this->title = [];
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * @return array
     */
    public function getDeviceIdList()
    {
        return $this->devices;
    }

    /**
     * @return array
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }



    /**
     * @param array $ids
     *
     * @return NotificationMessageInterface
     */
    public function setDeviceIdList(array $ids = [])
    {
        $this->devices = $ids;

        return $this;
    }

    /**
     * @param array $title
     *
     * @return NotificationMessageInterface
     */
    public function setTitle(array $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param array $attachment
     *
     * @return NotificationMessageInterface
     */
    public function setAttachment(array $attachment = null)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * @param array $content
     *
     * @return NotificationMessageInterface
     */
    public function setContent(array $content = null)
    {
        $this->content = $content;

        return $this;
    }
}
