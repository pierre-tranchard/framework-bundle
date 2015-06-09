<?php
/**
 * \file JsonValidatorTest.php
 * \project 2spark-Library
 * \author Pierre TRANCHARD
 * \version 1.0
 * \date 16/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\JsonValidator;

/**
 * Class JsonValidatorTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class JsonValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test is valid json string
     */
    public function testIsValidJsonString()
    {
        $this->assertTrue(JsonValidator::isValidJsonString(json_encode(array('hello' => 'world'))));

        $this->assertFalse(JsonValidator::isValidJsonString('{hello:world'));
    }
}
