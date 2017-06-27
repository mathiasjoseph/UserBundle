<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 23/09/16
 * Time: 10:24
 */

namespace Miky\Bundle\UserBundle\Controller\Admin;


use Doctrine\Common\Persistence\ObjectManager;
use Miky\Bundle\ResourceBundle\Controller\AuthorizationCheckerInterface;
use Miky\Bundle\ResourceBundle\Controller\EventDispatcherInterface;
use Miky\Bundle\ResourceBundle\Controller\FlashHelperInterface;
use Miky\Bundle\ResourceBundle\Controller\NewResourceFactoryInterface;
use Miky\Bundle\ResourceBundle\Controller\RedirectHandlerInterface;
use Miky\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Miky\Bundle\ResourceBundle\Controller\ResourceController;
use Miky\Bundle\ResourceBundle\Controller\ResourceFormFactoryInterface;
use Miky\Bundle\ResourceBundle\Controller\ResourcesCollectionProviderInterface;
use Miky\Bundle\ResourceBundle\Controller\SingleResourceProviderInterface;
use Miky\Bundle\ResourceBundle\Controller\StateMachineInterface;
use Miky\Bundle\ResourceBundle\Controller\ViewHandlerInterface;
use Miky\Component\Resource\Factory\FactoryInterface;
use Miky\Component\Resource\Metadata\MetadataInterface;
use Miky\Component\Resource\Repository\RepositoryInterface;

class CustomerAdminController extends ResourceController
{

}