<?php
/**
 * \file Logger.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 26/02/15
 * \brief Ensure the logger property is set in order to use it
 * \details
 */

namespace Spark\FrameworkBundle\Traits;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Logger
 *
 * @package Spark\FrameworkBundle\Traits
 */
trait Logger
{
    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * Set Logger
     *
     * @param string          $fileName
     * @param LoggerInterface $logger
     * @param OutputInterface $output
     */
    public function setLogger($fileName, LoggerInterface $logger = null, OutputInterface $output = null)
    {
        if (is_null($logger) === true) {
            $logger = new NullLogger();
        }
        if ($logger instanceof \Spark\FrameworkBundle\Component\Logger) {
            $filePath = $logger->createLogFile('logs', sprintf("%s.log", $fileName));
            $logger->createFileStream($filePath);
            if (is_null($output) === false) {
                $logger->setOutputInterface($output);
            }
        }
        $this->logger = $logger;
    }

    /**
     * Flush the buffer if logger is lightweight logger
     *
     * @return null|\Psr\Log\LoggerInterface|\Spark\FrameworkBundle\Component\Logger
     * @throws \Exception
     */
    public function flushBuffer()
    {
        if ($this->logger instanceof \Spark\FrameworkBundle\Component\Logger) {
            $this->logger->flushBuffer();
        }

        return $this->logger;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->emergency(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function alert($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->alert(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function critical($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->critical(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function error($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->error(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function warning($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->warning(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function notice($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->notice(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function info($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->info(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function debug($message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->debug(sprintf("%s\n", $message), $context);
        }
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        if (is_null($this->logger) === false && $this->logger instanceof LoggerInterface) {
            $this->logger->log($level, sprintf("%s\n", $message), $context);
        }
    }
}
