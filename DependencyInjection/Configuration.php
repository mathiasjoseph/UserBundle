<?php

namespace Miky\Bundle\UserBundle\DependencyInjection;

use Miky\Bundle\UserBundle\Doctrine\Entity\Employee;
use Miky\Bundle\UserBundle\Doctrine\Entity\User;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{

    private $useDefaultEntities;

    /**
     * Configuration constructor.
     */
    public function __construct($useDefaultEntities)
    {
        $this->useDefaultEntities = $useDefaultEntities;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('miky_user');
        if ($this->useDefaultEntities){
            $rootNode
                ->children()
                ->scalarNode('user_class')->defaultValue(User::class)->cannotBeEmpty()->end()
                ->scalarNode('employee_class')->defaultValue(Employee::class)->cannotBeEmpty()->end()
                ->end();
        }else{
            $rootNode
                ->children()
                ->scalarNode('employee_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->end();
        }

        return $treeBuilder;
    }
}
