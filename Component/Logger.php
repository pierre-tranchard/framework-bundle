<?php
/**
 * \file Logger.php
 * \author Benoit MAZIERE <benoit.maziere@gmail.com>
 * \version 1.0
 * \date 05/03/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Component;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class Logger
 *
 * @package Spark\FrameworkBundle\Component
 */
class Logger implements LoggerInterface
{

    /**
     * @var string
     */
    protected $kernelRootDir;
    /**
     * @var resource
     */
    protected $stream = null;
    /**
     * @var string
     */
    protected $buffer = '';
    /**
     * @var OutputInterface
     */
    protected $output = null;
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var string
     */
    protected $filePath = '';

    /**
     * Constructor
     *
     * @param $kernelRootDir
     */
    public function __construct($kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    /**
     * @param OutputInterface $outputInterface
     */
    public function setOutputInterface(OutputInterface $outputInterface)
    {
        $this->output = $outputInterface;
    }

    /**
     * @param string $filePath
     *
     * @param string $mode
     *
     * @return $this
     */
    public function createFileStream($filePath, $mode = "a")
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        $this->stream = fopen($filePath, $mode);

        return $this;
    }

    /**
     * @param string $folder
     * @param string $fileName
     *
     * @return string
     */
    public function createLogFile($folder = 'logs', $fileName)
    {
        $logFileDir = sprintf(
            '%s' . DIRECTORY_SEPARATOR . '%s',
            $this->kernelRootDir,
            $folder
        );

        if ($file = Finder::create()->name($fileName)->in($logFileDir)) {
            @unlink($logFileDir . DIRECTORY_SEPARATOR . $fileName);
        }

        $this->filePath = $logFileDir . DIRECTORY_SEPARATOR . $fileName;

        return $this->filePath;
    }

    /**
     * @param      $message
     * @param bool $fillBuffer
     * @param bool $printOut
     *
     * @return $this
     * @throws \Exception
     */
    public function printMessage($message, $fillBuffer = true, $printOut = true)
    {
        if ($fillBuffer) {
            if (empty($this->buffer)) {
                $this->buffer = sprintf("%s", $message);
            } else {
                $this->buffer = sprintf("%s\n%s", $this->buffer, $message);
            }
        }

        if ($printOut) {
            if (!$this->output instanceof OutputInterface) {
                throw new \Exception('You must set an output');
            }
            $this->output->writeln($message);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function flushBuffer()
    {
        if (!is_resource($this->stream)) {
            throw new \Exception('The stream is not resource');
        }
        $content = preg_replace('/<\/?(info|comment|error|fg=cyan|fg=blue|fg=red)>/', '', $this->buffer);

        fwrite($this->stream, $content);

        $this->buffer = '';
        $content      = null;

        return $this;
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage($message, true, false);
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
        return $this->printMessage(sprintf("%s - %s", $level, $message), true, false);
    }

    /**
     * Get Buffer
     *
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * Clear Buffer
     *
     * @return $this
     */
    public function clearBuffer()
    {
        $this->buffer = '';

        return $this;
    }
}
