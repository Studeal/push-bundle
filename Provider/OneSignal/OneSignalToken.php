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

use StudealPushBundle\Notification\Security\TokenInterface;

/**
 * Class OneSignalToken.
 */
final class OneSignalToken implements TokenInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * OneSignalToken constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function __toToken()
    {
        return (string) "Basic $this->key";
    }
}
