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

use StudealPushBundle\Notification\Security\TokenInterface;

/**
 * Class FirebaseToken
 */
class FirebaseToken implements TokenInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * FirebaseToken constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function __toToken()
    {
        return "key=".$this->token;
    }
}