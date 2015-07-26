<?php
/**
 * \file OTPGeneratorTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 07/05/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\Component;

use Spark\FrameworkBundle\Component\OTPGenerator;

/**
 * Class OTPGeneratorTest
 *
 * @package Spark\FrameworkBundle\Tests\Component
 */
class OTPGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test constructor
     */
    public function testConstructor()
    {
        try {
            $otpGenerator = new OTPGenerator("abc");
        } catch (\Exception $exception) {
            $this->assertInstanceOf("\\Exception", $exception);
        }

        $otpGenerator = new OTPGenerator(
            "D6C1F4CD546D478ED99C9B7C8C294A444A2DB8F109E0504474511C9EF8E9B604", 45, "sha1"
        );
        $reflection   = new \ReflectionClass($otpGenerator);

        $secretSeed = $reflection->getProperty("secretSeed");
        $secretSeed->setAccessible(true);

        $timeWindow = $reflection->getProperty("timeWindow");
        $timeWindow->setAccessible(true);

        $algorithm = $reflection->getProperty("algorithm");
        $algorithm->setAccessible(true);

        $this->assertEquals(
            "D6C1F4CD546D478ED99C9B7C8C294A444A2DB8F109E0504474511C9EF8E9B604",
            $secretSeed->getValue($otpGenerator)
        );
        $this->assertEquals(45, $timeWindow->getValue($otpGenerator));
        $this->assertEquals("sha1", $algorithm->getValue($otpGenerator));
    }

    /**
     * Test OTP Generation
     */
    public function testGenerateOTP()
    {
        $otpGenerator = new OTPGenerator(
            "D6C1F4CD546D478ED99C9B7C8C294A444A2DB8F109E0504474511C9EF8E9B604", 45, "sha1"
        );
        $expectedOTP  = $otpGenerator->generateOTP();

        $this->assertEquals($expectedOTP, $otpGenerator->generateOTP());
    }
}
