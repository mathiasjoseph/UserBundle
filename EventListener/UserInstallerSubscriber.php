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

        if ($this->employeeManager->findUserByUsername("admin") == null){
            $employee = $this->employeeManager->createUser();
            $employee->setEmail("admin@admin.fr");
            $employee->setPlainPassword("password");
            $employee->setUsername("admin");
            $employee->setEnabled(true);

            $this->employeeManager->updateUser($employee);

        }
        if ($this->userManager->findUserByUsername("user") == null){
            $customer = $this->userManager->createUser();
            $customer->setEmail("user@user.fr");
            $customer->setPlainPassword("password");
            $customer->setUsername("user");
            $customer->setEnabled(true);
            $this->userManager->updateUser($customer);

        }

    }
}