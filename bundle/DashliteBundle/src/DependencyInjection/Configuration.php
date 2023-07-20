<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder('devscast_dashlite');
        $root = $tree->getRootNode();

        $this->addApplicationSection($root);

        return $tree;
    }

    public function addApplicationSection(ArrayNodeDefinition|NodeDefinition $root): void
    {
        $root
            ->children()
                ->arrayNode('application')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultValue('Devscast Dashboard')->end()
                        ->scalarNode('title')->defaultValue('devscast.org')->end()
                        ->scalarNode('logo_path')->isRequired()->end()
                        ->scalarNode('icon_path')->isRequired()->end()
                        ->scalarNode('version')->defaultValue('1.0.0')->end()
                        ->scalarNode('copyrights')->defaultValue('')->end()
                    ->end()
                ->end()
            ->end();
    }
}
