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

use StudealPushBundle\Notification\Message\AbstractNotificationMessage;

/**
 * Class FirebaseNotificationMessage
 */
class FirebaseNotificationMessage extends AbstractNotificationMessage
{

    /**
     * @return string
     */
    public function getPayloadKey()
    {
        return 'data';
    }

    /**
     * @return string
     */
    public function toRoute()
    {
        return '';
    }

    /**
     * @return array
     */
    public function toRequest()
    {
        return [
            "notification" => [
                "title" => $this->getTitle(),
                "body" => $this->getContent()
            ],
            "registration_ids" => $this->getDevices(),
            "data" => $this->buildPayloadWithKey()
        ];
    }
}