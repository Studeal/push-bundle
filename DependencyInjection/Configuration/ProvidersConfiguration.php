<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StudealPushBundle\DependencyInjection\Configuration;

use ReflectionClass;
use StudealPushBundle\Exception\UndefinedProviderException;
use StudealPushBundle\Notification\Security\TokenInterface;
use StudealPushBundle\Provider\Firebase\FirebaseNotificationService;
use StudealPushBundle\Provider\Firebase\FirebaseToken;
use StudealPushBundle\Provider\OneSignal\OneSignalNotificationService;
use StudealPushBundle\Provider\OneSignal\OneSignalToken;

/**
 * Class ProvidersConfiguration.
 */
class ProvidersConfiguration
{
    /**
     * @param $provider
     * @param $apiKey
     *
     * @return Configuration
     */
    public static function factory($provider, $apiKey)
    {
        switch ($provider) {
            case 'oneSignal':
                return self::Onesignal($apiKey);
            case 'firebase':
                return self::Firebase($apiKey);

            default:
                throw new UndefinedProviderException();
        }
    }

    /**
     * @return Configuration
     */
    private static function Onesignal($apiKey)
    {
        return new Configuration('https://onesignal.com/api/v1/notifications', new OneSignalToken($apiKey), OneSignalNotificationService::class);
    }

    /**
     * @return Configuration
     */
    private static function Firebase($apiKey)
    {
        return new Configuration('https://fcm.googleapis.com/fcm/send', new FirebaseToken($apiKey), FirebaseNotificationService::class);
    }
}

/**
 * Class Configuration.
 */
class Configuration
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $token;
    private $class;

    /**
     * Configuration constructor.
     *
     * @param string         $baseUri
     * @param TokenInterface $token
     * @param string         $class
     */
    public function __construct($baseUri, TokenInterface $token, $class)
    {
        $this->baseUri = $baseUri;
        $this->token = $token;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param $args
     *
     * @return \StudealPushBundle\Notification\AbstractNotificationService
     */
    public function instanciateClass($args)
    {
        $r = new ReflectionClass($this->class);

        return $r->newInstanceArgs($args);
    }
}
