<?php

namespace Simonsimcity\CouchbaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SimonsimcityCouchbaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['profiler_enabled']) {
            $loader->load('services_profiler_enabled.xml');
        }

        foreach($config['connections'] as $id => $connection) {
            $this->createCouchbaseDefinition($container, $id, $connection);
        }
    }

    private function createCouchbaseDefinition(ContainerBuilder $container, $id, $configuration)
    {
        $provider = 'couchbase.' . $id;
        $container
            ->setDefinition(
                $provider,
                new DefinitionDecorator('couchbase')
            )
            ->replaceArgument(0, $configuration['host'])
            ->replaceArgument(1, $configuration['username'])
            ->replaceArgument(2, $configuration['password'])
            ->replaceArgument(3, $configuration['bucket'])
            ->replaceArgument(4, $configuration['persistent'])
        ;
    }
}
