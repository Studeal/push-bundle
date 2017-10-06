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
 * Interface TokenInterface
 */
interface TokenInterface
{
    /**
     * @return string
     */
    public function __toToken();

    /**
     * @return string
     */
    public function getAppId();
}
