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
    public function getPayloadKey()
    {
        return 'data';
    }

    /**
     * @param mixed  $data
     * @param string $locale
     *
     * @return array
     */
    private function buildLocalizedRow($data, $locale)
    {
        $row = [];
        if ($locale !== 'en') {
            $row['en'] = $data;
        }
        $row[$locale] = $data;

        return $row;
    }

    /**
     * @return array
     */
    public function toRequest()
    {
        $requestData = [
            "app_id" => $this->getExtraData()->get('appId'),
            "included_segments" => ["All"],
            'headings' => $this->buildLocalizedRow($this->getTitle(), $this->getLocale()),
            "contents" => $this->buildLocalizedRow($this->getContent(), $this->getLocale()),
            "include_player_ids" => $this->getDevices(),
        ];

        $requestData[$this->getPayloadKey()] = $this->buildPayloadWithKey();

        return $requestData;
    }

    /**
     * @return string
     */
    public function toRoute()
    {
        $data = $this->getExtraData();
        $route = '';
        if ($notificationId = $data->get('notitifationId')) {
            $route .= '/'.$notificationId;
        }
        if ($appId = $data->get('appId')) {
            $route .= '?app_id='.$appId;
        }
        if ($limit = $data->get('limit')) {
            $route .= '&limit='.$limit;
        }
        if ($offset = $data->get('offset')) {
            $route .= '&offset='.$offset;
        }

        return $route;
    }
}
