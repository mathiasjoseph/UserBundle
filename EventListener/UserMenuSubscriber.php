<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/11/16
 * Time: 04:06
 */

namespace Miky\Bundle\UserBundle\EventListener;



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

        $employeeSubMenu = $menu
            ->addChild('employee')
            ->setLabel('miky_user.employees')
            ->setLabelAttribute('icon', 'users')
        ;
        $employeeList = $employeeSubMenu
            ->addChild('employee_list', ['route' => 'miky_user_admin_user_index'])
            ->setLabel('miky_user.employee')
            ->setLabelAttribute('icon', 'bullhorn')
        ;
        $userSubMenu = $menu
            ->addChild('user')
            ->setLabel('miky_user.users')
            ->setLabelAttribute('icon', 'users')
        ;


    }
}