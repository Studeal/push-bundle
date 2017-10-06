<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Provider\OneSignal;

use StudealPushBundle\Notification\Message\AbstractNotificationMessage;
use StudealPushBundle\Notification\Message\NotificationMessageInterface;

/**
 * Class OneSignalNotificationMessage
 */
class OneSignalNotificationMessage extends AbstractNotificationMessage
{
    /*
    [
        "app_id": "5eb5a37e-b458-11e3-ac11-000c2940e62c",
        "contents": {
            "en": "English Message"
        },
        "include_player_ids": [
            "6392d91a-b206-4b7b-a620-cd68e32c3a76",
            "76ece62b-bcfe-468c-8a78-839aeaa8c5fa",
            "8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86"
        ]
    ]
    */

    /**
     * @return string
     */
    public function getAttachmentKey()
    {
        return 'data';
    }

    /**
     * @return array
     */
    public function toRequest()
    {
        $contents = [];
        $titles = [];
        foreach ($this->getContent() as $lang => $content) {
            $contents[$lang] = $content;
        }
        foreach ($this->getTitle() as $lang => $title) {
            $titles[$lang] = $title;
        }
        $requestData = [
            "app_id" => $this->getAppId(),
            "included_segments" => ["All"],
            'headings' => $titles,
            "contents" => $contents,
            "include_player_ids" => $this->getDeviceIdList(),
        ];

        $requestData[$this->getAttachmentKey()] = $this->getAttachment();

        return $requestData;
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

    /**
     * @return array
     */
    public function getExtraData()
    {
        return []; //here we don't use it
    }
}
