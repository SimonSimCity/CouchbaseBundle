<?php

namespace Simonsimcity\CouchbaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('simonsimcity_couchbase');

        $rootNode
            ->children()
                ->booleanNode('profiler_enabled')->defaultValue(false)->end()

                ->arrayNode('cluster')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('dsn')
                                ->cannotBeEmpty()
                                ->defaultValue('http://127.0.0.1/')
                            ->end()

                            ->scalarNode('username')
						        ->defaultNull()
                            ->end()

                            ->scalarNode('password')
						        ->defaultNull()
                            ->end()

                            ->arrayNode('buckets')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey('key')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                        ->end()

                                        ->scalarNode('password')
                                            ->defaultValue('')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
