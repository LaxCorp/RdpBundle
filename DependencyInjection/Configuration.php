<?php

namespace LaxCorp\RdpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @inheritdoc
 */
class Configuration implements ConfigurationInterface
{

    const ROOT = 'rdp';

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root($this::ROOT);

        $rootNode
            ->children()
            ->scalarNode('full_address')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}