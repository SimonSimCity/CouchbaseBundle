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
                ->arrayNode('connections')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('host')
                                ->cannotBeEmpty()
                                ->defaultValue('localhost')
                            ->end()

                            ->integerNode('port')
                                ->cannotBeEmpty()
                                ->defaultValue('8091')
                            ->end()

                            ->scalarNode('username')
                            ->end()

                            ->scalarNode('password')
                            ->end()

                            ->scalarNode('bucket')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()

                            ->booleanNode('persistent')
                                ->defaultValue(true)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
