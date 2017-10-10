<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace StudealPushBundle\Notification\Http\Traits;

use Psr\Log\LoggerInterface;

/**
 * Trait LoggableTrait
 */
trait LoggableTrait
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    protected function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param string $message
     */
    protected function logError($message)
    {
        if ($this->logger) {
            $this->logger->error($message);
        }
    }

    /**
     * @param string $message
     */
    protected function logNotice($message)
    {
        if ($this->logger) {
            $this->logger->notice($message);
        }
    }
}
