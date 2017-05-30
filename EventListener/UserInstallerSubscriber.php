<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/11/16
 * Time: 04:06
 */

namespace Miky\Bundle\UserBundle\EventListener;



use Miky\Bundle\AdminBundle\Menu\AdminMenuBuilder;
use Miky\Bundle\InstallerBundle\Event\InstallationEvent;
use Miky\Bundle\InstallerBundle\MikyInstallerEvents;
use Miky\Bundle\MenuBundle\Event\MenuBuilderEvent;
use Miky\Bundle\UserBundle\Doctrine\EmployeeManager;
use Miky\Bundle\UserBundle\Doctrine\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserInstallerSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var EmployeeManager
     */
    private $employeeManager;

    /**
     * UserInstallerSubscriber constructor.
     * @param UserManager $userManager
     * @param EmployeeManager $employeeManager
     */
    public function __construct(UserManager $userManager, EmployeeManager $employeeManager)
    {
        $this->userManager = $userManager;
        $this->employeeManager = $employeeManager;
    }


    public static function getSubscribedEvents()
    {
        return array(
            MikyInstallerEvents::INSTALL_INITIALIZE => 'onInstallation',
        );
    }

    public function onInstallation(InstallationEvent $event)
    {
        $installation = $event->getInstallation();


    }
}