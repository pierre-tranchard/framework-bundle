<?php
/**
 * \file ScramblerCompilerPassTest.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 18/04/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Tests\DependencyInjection\Compiler;

use Spark\FrameworkBundle\DependencyInjection\Compiler\ScramblerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ScramblerCompilerPassTest
 *
 * @package Spark\FrameworkBundle\Tests\DependencyInjection\Compiler
 */
class ScramblerCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test scrambler compiler pass with empty parameter
     */
    public function testProcessWithEmptyContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $compilerPass     = new ScramblerCompilerPass();

        $compilerPass->process($containerBuilder);

        try {
            $containerBuilder->getParameter('spark_framework.component.scrambler_clients');
        } catch (\Exception $exception) {
            $this->assertEquals(
                'You have requested a non-existent parameter "spark_framework.component.scrambler_clients".',
                $exception->getMessage()
            );
            $this->throwException($exception);
        }
    }

    /**
     * Test scrambler compiler pass with clients in container
     */
    public function testProcessWithScramblerClientsInContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $compilerPass     = new ScramblerCompilerPass();
        $randomClientKey  = '72E5D627D685367C77AF9815B2750692F46F47E2FBBCF5255118A82EE94DC2BA';
        $containerBuilder->setParameter(
            'spark_framework.component.scrambler_clients',
            array(
                'random_client' => $randomClientKey
            )
        );
        $containerBuilder->setParameter(
            'spark_framework.component.scrambler.class',
            '\Spark\FrameworkBundle\Component\Scrambler'
        );

        $compilerPass->process($containerBuilder);
        $scrambler = $containerBuilder->get('spark_framework.component.scrambler.random_client');
        $this->assertInstanceOf(
            '\Spark\FrameworkBundle\Component\Scrambler',
            $scrambler
        );
    }
}
