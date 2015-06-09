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

namespace Spark\FrameworkBundle\Tests\Traits;

use Spark\FrameworkBundle\Traits\Logger;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class LoggerTest
 *
 * @package Spark\FrameworkBundle\Tests\Traits
 */
class LoggerTest extends KernelTestCase
{
    use Logger;

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

    /**
     * Test set logger
     */
    public function testSetLogger()
    {
        $this->setLogger('test');
        $this->setLogger('test', new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir), new NullOutput());

        $this->assertTrue(true);
    }

    /**
     * Test flush buffer
     */
    public function testFlushBuffer()
    {
        $this->assertNull($this->flushBuffer());
        $this->setLogger('test', new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir));
        $this->assertInstanceOf('\Spark\FrameworkBundle\Component\Logger', $this->flushBuffer());
    }

    /**
     * System is unusable.
     */
    public function testEmergency()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->emergency('emergency');

        $this->assertEquals(sprintf("%s\n", 'emergency'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Action must be taken immediately.
     */
    public function testAlert()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->alert('alert');

        $this->assertEquals(sprintf("%s\n", 'alert'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Critical conditions.
     */
    public function testCritical()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->critical('critical');

        $this->assertEquals(sprintf("%s\n", 'critical'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    public function testError()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->error('error');

        $this->assertEquals(sprintf("%s\n", 'error'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Exceptional occurrences that are not errors.
     */
    public function testWarning()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->warning('warning');

        $this->assertEquals(sprintf("%s\n", 'warning'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Normal but significant events.
     */
    public function testNotice()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->notice('notice');

        $this->assertEquals(sprintf("%s\n", 'notice'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Interesting events.
     */
    public function testInfo()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->info('info');

        $this->assertEquals(sprintf("%s\n", 'info'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Detailed debug information.
     */
    public function testDebug()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->debug('debug');

        $this->assertEquals(sprintf("%s\n", 'debug'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Logs with an arbitrary level.
     */
    public function testLog()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->log('test', 'log');

        $this->assertEquals(sprintf("%s\n", 'test - log'), $logger->getBuffer());

        $logger->clearBuffer();
    }

    /**
     * Test if no stream was created
     */
    public function testFlushBufferWithoutStream()
    {
        $logger = new \Spark\FrameworkBundle\Component\Logger(self::$kernelRootDir);
        $this->setLogger('test', $logger);
        $this->alert('no stream !');

        try {
            $logger->flushBuffer();
        } catch (\Exception $exception) {
            $this->throwException($exception);
            $this->assertEquals('The stream is not resource', $exception->getMessage());
        }
    }
}
