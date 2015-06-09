<?php
/**
 * \file ConnectionLoggerTest.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 16/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Traits;

use Spark\FrameworkBundle\Traits\ConnectionLogger;

/**
 * Class ConnectionLoggerTest
 *
 * @package Spark\FrameworkBundle\Tests\Traits
 */
class ConnectionLoggerTest extends \PHPUnit_Framework_TestCase
{
    use ConnectionLogger;

    /**
     * Test trait disable connection logger
     */
    public function testTrait()
    {
        $connectionMock    = $this->getMock('\Doctrine\DBAL\Connection', array(), array(), "", false);
        $configurationMock = $this->getMock('\Doctrine\DBAL\Configuration', array(), array(), "", false);

        $connectionMock->expects($this->any())
            ->method('getConfiguration')
            ->will($this->returnValue($configurationMock));

        $this->assertEquals($connectionMock, $this->disableConnectionLogger($connectionMock));
    }
}
