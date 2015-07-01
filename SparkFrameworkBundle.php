<?php

namespace Spark\FrameworkBundle;

use Spark\FrameworkBundle\DependencyInjection\Compiler\OTPGeneratorCompilerPass;
use Spark\FrameworkBundle\DependencyInjection\Compiler\ScramblerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SparkFrameworkBundle
 *
 * @package Spark\FrameworkBundle
 *
 * @codeCoverageIgnore
 */
class SparkFrameworkBundle extends Bundle
{

    /**
     * Build Container
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ScramblerCompilerPass());
        $container->addCompilerPass(new OTPGeneratorCompilerPass());
    }
}
