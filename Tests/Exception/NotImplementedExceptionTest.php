<?php
/**
 * \file NotImplementedExceptionTest.php
 * \project Spark
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Exception;

use Spark\FrameworkBundle\Exception\NotImplementedException;

/**
 * Class NotImplementedExceptionTest
 *
 * @package Spark\FrameworkBundle\Tests\Exception
 */
class NotImplementedExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test repository exception
     */
    public function testRepository()
    {
        $method = 'getBy';
        $repository = 'SparkFrameworkBundle:Document';
        $exception = NotImplementedException::repository($method, $repository);

        $this->assertEquals(
            sprintf("%s method was not found in %s repository", $method, $repository),
            $exception->getMessage()
        );
    }
}
