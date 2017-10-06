<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Exception;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Trait ExceptionHandler
 */
trait ExceptionHandlerTrait
{
    /**
     * @var array
     */
    protected static $exceptionStack = [];

    /**
     * @return \Closure
     */
    protected static function registerNotificationException()
    {
        return static::resolveExceptionFromName(__FUNCTION__, 400);
    }

    /**
     * @param BadResponseException $brException
     *
     * @return \Exception
     */
    protected static function getExceptionFromCode(BadResponseException $brException)
    {
        if (!isset(static::$exceptionStack[$brException->getCode()])) {
            return new UndefinedClientException($brException->getMessage());
        }
        $exception = static::$exceptionStack[$brException->getCode()];

        $exceptionClass = $exception($brException->getResponse()->getBody()->getContents());
        static::clearExceptionStack();

        return $exceptionClass;
    }


    /**
     * @return void
     */
    private static function clearExceptionStack()
    {
        static::$exceptionStack = [];
    }

    /**
     * @param string $functionName
     * @param int    $errorCode
     *
     * @return \Closure
     */
    private static function resolveExceptionFromName($functionName, $errorCode)
    {
        $exceptionName = __NAMESPACE__.preg_replace('/register/', '\\', $functionName, 1);

        return self::prepareException($errorCode, $exceptionName);
    }

    /**
     * @param string $functionName
     * @param string $namespace
     * @param int    $errorCode
     *
     * @return \Closure
     */
    private static function resolveExceptionFromNameInSpecificNamespace($functionName, $namespace, $errorCode)
    {
        $exceptionName = __NAMESPACE__.preg_replace('/register/', '\\'.$namespace.'\\', $functionName, 1);

        return self::prepareException($errorCode, $exceptionName);
    }

    /**
     * @param int    $errorCode
     * @param string $exceptionName
     *
     * @return \Closure
     */
    private static function prepareException($errorCode, $exceptionName)
    {
        return static::$exceptionStack[$errorCode] = function ($message) use ($exceptionName) {
            return new $exceptionName($message);
        };
    }
}
