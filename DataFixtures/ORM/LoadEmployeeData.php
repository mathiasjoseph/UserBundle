<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 22/08/16
 * Time: 00:06
 */

namespace Miky\Bundle\UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Miky\Bundle\UserBundle\Entity\Employee;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadEmployeeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('miky_employee_manager');
        $employee = new Employee();
        $employee->setUsername('admin');
        $employee->setPlainPassword('admin');
        $employee->setEmail('jhyfy');
        $employee->setEnabled(true);

        $userManager->updateUser($employee);

        $this->addReference('employee', $employee);
    }

    public function getOrder()
    {
        return 1;
    }
}