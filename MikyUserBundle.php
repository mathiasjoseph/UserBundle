<?php

namespace Miky\Bundle\UserBundle;

use Miky\Bundle\UserBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

class MikyUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
