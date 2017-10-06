<?php
/*
 * This file is part of the Studeal package.
 *
 * (c) Studeal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Studeal\PushBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('studeal_push');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        //todo manage later providers for being able to push to different service (firebase, aws, ionic, ...)
        $rootNode
            ->children()
                ->scalarNode('notification.base_uri')->cannotBeEmpty()->end()
                ->scalarNode('notification.app_id')->cannotBeEmpty()->end()
                ->scalarNode('notification.app_secret')->cannotBeEmpty()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
