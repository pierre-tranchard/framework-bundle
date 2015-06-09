<?php
/**
 * \file LoggerTest.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 17/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class LoggerTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class LoggerTest extends KernelTestCase
{
    /**
     * @var null|string
     */
    private static $kernelRootDir;

    /**
     * Get Kernel Root Dir
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$kernelRootDir = $kernel->getRootDir();
    }

    /**
     * Clear Kernel Root Dir
     */
    public function tearDown()
    {
        self::$kernelRootDir = null;
    }

    public function testPrintMessage()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->emergency('emergency');
        $logger->alert('alert');

        $this->assertEquals(sprintf("%s\n%s", 'emergency', 'alert'), $logger->getBuffer());
        $logger->clearBuffer();

        try {
            $logger->printMessage("Hello", false, true);
        } catch (\Exception $exception) {
            $this->throwException($exception);
            $this->assertEquals('You must set an output', $exception->getMessage());
        }

        $outputMock = $this->getMock('\Symfony\Component\Console\Output\NullOutput', array(), array(), "", false);

        $outputMock->expects($this->any())
            ->method('writeln')
            ->with($this->isType('string'))
            ->will($this->returnArgument(0));

        $logger->setOutputInterface($outputMock);

        $logger->printMessage('hello');
        $this->assertEquals('hello', $logger->getBuffer());
        $logger->clearBuffer();
    }

    public function testStream()
    {
        $logger   = new Logger(self::$kernelRootDir);
        $filePath = $logger->createLogFile('logs', 'test.log');
        $logger->createFileStream($filePath);

        $logger->flushBuffer();
        $this->assertFileExists($filePath);

        $newFilePath = $logger->createLogFile('logs', 'test2.log');
        $logger->createFileStream($newFilePath);

        $logger->flushBuffer();
        $this->assertFileExists($filePath);

        unlink($filePath);
        unlink($newFilePath);
    }

    /**
     * System is unusable.
     */
    public function testEmergency()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->emergency('emergency');

        $this->assertEquals('emergency', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Action must be taken immediately.
     */
    public function testAlert()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->alert('alert');

        $this->assertEquals('alert', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Critical conditions.
     */
    public function testCritical()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->critical('critical');

        $this->assertEquals('critical', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    public function testError()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->error('error');

        $this->assertEquals('error', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Exceptional occurrences that are not errors.
     */
    public function testWarning()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->warning('warning');

        $this->assertEquals('warning', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Normal but significant events.
     */
    public function testNotice()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->notice('notice');

        $this->assertEquals('notice', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Interesting events.
     */
    public function testInfo()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->info('info');

        $this->assertEquals('info', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Detailed debug information.
     */
    public function testDebug()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->debug('debug');

        $this->assertEquals('debug', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Logs with an arbitrary level.
     */
    public function testLog()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->log('test', 'log');

        $this->assertEquals('test - log', $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Test if log file exists
     */
    public function testCreateLogFile()
    {
        $logger   = new Logger(self::$kernelRootDir);
        $filePath = $logger->createLogFile('logs', 'test.log');
        $logger->createFileStream($filePath);
        $logger->log('test', 'log');
        $logger->flushBuffer();
        $this->assertFileExists($filePath);

        unlink($filePath);
    }

    /**
     * Test flush buffer
     */
    public function testFlushBuffer()
    {
        $logger   = new Logger(self::$kernelRootDir);
        $filePath = $logger->createLogFile('logs', 'test.log');
        $logger->createFileStream($filePath);
        $logger->log('test', 'log');
        $logger->flushBuffer();
        $this->assertEquals('', $logger->getBuffer());
    }

    /**
     * Test if no stream was created
     */
    public function testFlushBufferWithoutStream()
    {
        $logger = new Logger(self::$kernelRootDir);
        $logger->alert('no stream !');

        try {
            $logger->flushBuffer();
        } catch (\Exception $exception) {
            $this->throwException($exception);
            $this->assertEquals('The stream is not resource', $exception->getMessage());
        }
    }
}
