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
     * @return array
     */
    public function getPayload();

    /**
     * @return string
     */
    public function getPayloadKey();

    /**
     * @return array
     */
    public function getTitle();

    /**
     * @return array
     */
    public function getContent();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @return string
     */
    public function toRoute();

    /**
     * @return Map
     */
    public function getExtraData();

    /**
     * @return array
     */
    public function toRequest();
}

/**
 * Class Map
 */
class Map
{
    /**
     * @var array
     */
    private $data;

    /**
     * Map constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if (!array_key_exists($key, $this->data)) {
            return $default;
        }

        return $this->data[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

}
