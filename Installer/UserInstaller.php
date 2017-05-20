<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 15:32
 */

namespace Miky\Bundle\UserBundle\Installer;


use Miky\Bundle\InstallerBundle\Model\InstallerInterface;
use Miky\Bundle\UserBundle\Manager\UserManager;
use Miky\Bundle\UserBundle\Manager\EmployeeManager;

class UserInstaller implements InstallerInterface
{
    protected $employeeManager;

    protected $customerManager;

    /**
     * UserInstaller constructor.
     * @param $employeeManager
     */
    public function __construct(EmployeeManager $employeeManager, UserManager $customerManager)
    {
        $this->employeeManager = $employeeManager;
        $this->customerManager = $customerManager;
    }


    public function run(){
        if ($this->employeeManager->findUsers() == null){
        $employee = $this->employeeManager->createUser();
        $employee->setEmail("admin@admin.fr");
        $employee->setPlainPassword("admin");
        $employee->setUsername("admin");
            $employee->setEnabled(true);

        $this->employeeManager->updateUser($employee);

        }
        if ($this->customerManager->findUsers() == null){
            $customer = $this->customerManager->createUser();
            $customer->setEmail("user@user.fr");
            $customer->setPlainPassword("user");
            $customer->setUsername("user");
            $customer->setEnabled(true);
            $this->customerManager->updateUser($customer);

        }

    }
}