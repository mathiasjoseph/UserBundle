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
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCustomerData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userManager = $this->container->get('miky_customer_manager');
        $customer = new Customer();
        $customer->setUsername('admin');
        $customer->setPlainPassword('test');
        $customer->setEmail('jhyfy');
        $customer->setEnabled(true);

        $userManager->updateUser($customer);

        $this->addReference('customer', $customer);
    }

    public function getOrder()
    {
        return 1;
    }
}