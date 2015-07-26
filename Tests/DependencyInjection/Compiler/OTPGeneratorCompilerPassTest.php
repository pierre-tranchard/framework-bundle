<?php
/**
 * \file OTPGeneratorCompilerPassTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 02/07/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\DependencyInjection\Compiler;

use Spark\FrameworkBundle\DependencyInjection\Compiler\OTPGeneratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class OTPGeneratorCompilerPassTest
 *
 * @package Spark\FrameworkBundle\Tests\DependencyInjection\Compiler
 */
class OTPGeneratorCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test otp generator compiler pass with empty parameter
     */
    public function testProcessWithEmptyContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $compilerPass     = new OTPGeneratorCompilerPass();

        $compilerPass->process($containerBuilder);

        try {
            $containerBuilder->getParameter('spark_otp_generator_clients');
        } catch (\Exception $exception) {
            $this->assertEquals(
                'You have requested a non-existent parameter "spark_otp_generator_clients".',
                $exception->getMessage()
            );
            $this->throwException($exception);
        }
    }

    /**
     * Test otp generator compiler pass with clients in container
     */
    public function testProcessWithOTPGeneratorClientsInContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $compilerPass     = new OTPGeneratorCompilerPass();
        $containerBuilder->setParameter(
            'spark_otp_generator_clients',
            array(
                'random_client' => array(
                    'secret_seed' => 'D6C1F4CD546D478ED99C9B7C8C294A444A2DB8F109E0504474511C9EF8E9B604',
                    'time_window' => 45,
                    'algorithm'   => 'sha1',
                )
            )
        );
        $containerBuilder->setParameter(
            'spark_framework.component.otp_generator.class',
            '\Spark\FrameworkBundle\Component\OTPGenerator'
        );

        $compilerPass->process($containerBuilder);
        $scrambler = $containerBuilder->get('spark_framework.component.otp_generator.random_client');
        $this->assertInstanceOf(
            '\Spark\FrameworkBundle\Component\OTPGenerator',
            $scrambler
        );
    }
}
