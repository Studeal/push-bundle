<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Security;

/**
 * Class NotificationToken
 */
final class NotificationToken implements TokenInterface
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $key;

    /**
     * NotificationToken constructor.
     * @param string $appId
     * @param string $key
     */
    public function __construct($appId, $key)
    {
        $this->appId = $appId;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function __toToken()
    {
        return (string) "Basic $this->key";
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }
}
