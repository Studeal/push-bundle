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
 * Class AbstractNotificationMessage
 */
abstract class AbstractNotificationMessage implements NotificationMessageInterface
{

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
    protected $payload;

    /**
     * @var array
     */
    protected $content;
    /**
     * @var Map
     */
    private $extraData;

    /**
     * @var string
     */
    private $locale;

    /**
     * NotificationMessage constructor.
     * @param string $title
     * @param string $content
     * @param array $devices
     * @param array $extraData
     * @param string $locale
     */
    public function __construct($title = null, $content = null, array $devices = [], array $payload = [], array $extraData = [], $locale = 'fr')
    {
        $this->title = $title;
        $this->content = $content;
        $this->devices = $devices;
        $this->payload = $payload;
        $this->extraData = new Map($extraData);
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function buildPayloadWithKey($key = 'payload')
    {
        if (!array_key_exists($key, $this->payload)) {
            $payload = [];
            $payload[$key] = $this->payload;
            $this->payload = $payload;
        }


        return $this->payload;
    }

    /**
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return Map
     */
    public function getExtraData()
    {
        return $this->extraData;
    }
}
