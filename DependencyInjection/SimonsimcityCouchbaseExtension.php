<?php

namespace Simonsimcity\CouchbaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
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
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['profiler_enabled']) {
            $loader->load('services_profiler_enabled.xml');
        }

        foreach ($config['cluster'] as $id => $connection) {
            $this->createCouchbaseClusterDefinition($container, $id, $connection);
        }
    }

    private function createCouchbaseClusterDefinition(ContainerBuilder $container, $id, $configuration)
    {
        $provider = 'couchbase.cluster.'.$id;
        $container
            ->setDefinition(
                $provider,
                new DefinitionDecorator('couchbase.cluster')
            )
            ->replaceArgument(0, $configuration['dsn'])
            ->replaceArgument(1, $configuration['username'])
            ->replaceArgument(2, $configuration['password']);

        foreach ($configuration['buckets'] as $id => $connection) {
            $this->createCouchbaseBucketDefinition($container, $id, $connection, $provider);
        }
    }

    private function createCouchbaseBucketDefinition(ContainerBuilder $container, $id, $configuration, $clusterId)
    {
        $provider = 'couchbase.bucket.'.$id;
        $container
            ->setDefinition(
                $provider,
                new DefinitionDecorator('couchbase.bucket')
            )
            ->setFactory(
                array(
                    new Reference($clusterId),
                    'openBucket',
                )
            )
            ->replaceArgument(0, $configuration['name'])
            ->replaceArgument(1, $configuration['password']);
    }
}
