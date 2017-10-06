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
}
