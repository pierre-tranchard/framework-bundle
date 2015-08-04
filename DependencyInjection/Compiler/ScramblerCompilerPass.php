<?php
/**
 * \file ScramblerCompilerPass.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 14/01/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class ScramblerCompilerPass
 *
 * @package Spark\FrameworkBundle\DependencyInjection\Compiler
 */
class ScramblerCompilerPass implements CompilerPassInterface
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
        if ($container->hasParameter('spark_framework.component.scrambler_clients')) {
            $scramblerClients = $container->getParameter('spark_framework.component.scrambler_clients');

            if (is_array($scramblerClients)) {
                foreach ($scramblerClients as $client => $encryptionKey) {
                    $definition = new Definition(
                        $container->getParameter('spark_framework.component.scrambler.class'),
                        array($encryptionKey)
                    );
                    $definition->setPublic(false);
                    $container->setDefinition(sprintf('spark_framework.component.scrambler.%s', $client), $definition);
                }
            }
        }
    }
}
