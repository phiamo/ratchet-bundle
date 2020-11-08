<?php
/**
 * This file is part of the RatchetBundle project.
 *
 * (c) 2013 Philipp Boes <mostgreedy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace P2\Bundle\RatchetBundle\DependencyInjection;

use P2\Bundle\RatchetBundle\WebSocket\Server\Factory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package P2\Bundle\RatchetBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('p2_ratchet');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('provider')->defaultNull()->end()
                ->scalarNode('address')->defaultValue(Factory::ADDRESS)->end()
                ->scalarNode('port')->defaultValue(Factory::PORT)->end()
            ->end();

        return $treeBuilder;
    }
}
