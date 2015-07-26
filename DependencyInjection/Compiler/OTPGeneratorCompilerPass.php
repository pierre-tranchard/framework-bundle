<?php
/**
 * \file OTPGeneratorCompilerPass.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 06/05/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class OTPGeneratorCompilerPass
 *
 * @package Spark\ApiBundle\DependencyInjection\Compiler
 */
class OTPGeneratorCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('spark_otp_generator_clients')) {
            $otpClients = $container->getParameter('spark_otp_generator_clients');

            if (is_array($otpClients)) {
                foreach ($otpClients as $client => $otpOptions) {
                    $definition = new Definition(
                        $container->getParameter('spark_framework.component.otp_generator.class'), $otpOptions
                    );
                    $container->setDefinition(
                        sprintf('spark_framework.component.otp_generator.%s', $client),
                        $definition
                    );
                }
            }
        }
    }
}