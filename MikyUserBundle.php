<?php

namespace Miky\Bundle\UserBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class MikyUserBundle extends Bundle
{
    private $useDefaultEntities;

    public function __construct($useDefaultEntities = true) {
        $this->useDefaultEntities = $useDefaultEntities;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->setParameter("miky_user.use_default_entities", $this->useDefaultEntities);
        $this->addRegisterMappingsPass($container);
    }


    /**
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine-mapping') => 'Miky\Bundle\UserBundle\Model',
        );
        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('miky_user.model_manager_name')));
        }
        if ($this->useDefaultEntities){
            $mappingsBase = array(
                realpath(__DIR__.'/Resources/config/doctrine-base') => 'Miky\Bundle\UserBundle\Doctrine\Entity',
            );
            if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
                $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappingsBase, array('miky_user.entity_manager_name')));
            }
        }
    }
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
