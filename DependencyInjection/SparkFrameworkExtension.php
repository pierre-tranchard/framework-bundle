<?php

namespace Spark\FrameworkBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @codeCoverageIgnore
 */
class SparkFrameworkExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        static::loadXMLFiles(new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config')));
        static::loadYAMLFiles(new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config')));
    }

    /**
     * @param Loader\XmlFileLoader $loader
     */
    protected static function loadXMLFiles(Loader\XmlFileLoader $loader)
    {
        $loader->load('services.xml');
        $loader->load('validator.xml');
        $loader->load('paginator.xml');
        $loader->load('twig.xml');
    }

    /**
     * @param Loader\YamlFileLoader $loader
     */
    protected static function loadYAMLFiles(Loader\YamlFileLoader $loader)
    {
        $loader->load('parameters.yml');
    }
}
