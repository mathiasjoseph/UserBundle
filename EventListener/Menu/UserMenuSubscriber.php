<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/11/16
 * Time: 04:06
 */

namespace Miky\Bundle\UserBundle\EventListener\Menu;



use Miky\Bundle\AdminBundle\Menu\AdminMenuBuilder;
use Miky\Bundle\MenuBundle\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserMenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            AdminMenuBuilder::EVENT_NAME => 'onAdminMenu',
        );
    }

    public function onAdminMenu(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

//        $employeeSubMenu = $menu
//            ->addChild('employee')
//            ->setLabel('miky.ui.employees')
//            ->setLabelAttribute('icon', 'users')
//        ;
//        $userSubMenu = $menu
//            ->addChild('user')
//            ->setLabel('miky.ui.users')
//            ->setLabelAttribute('icon', 'users')
//        ;
//        $l = $userSubMenu
//            ->addChild('users_list', ['route' => 'miky_admin_user_index'])
//            ->setLabel('miky.ui.users_list')
//            ->setLabelAttribute('icon', 'bullhorn')
//        ;
//        $l
//            ->addChild('users_list', ['route' => 'miky_admin_user_index'])
//            ->setLabel('miky.ui.users_list')
//            ->setLabelAttribute('icon', 'bullhorn')
//        ;
    }
}