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

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $user = new Customer();
        $user->setUsername('admin');
        $user->setPlainPassword('test');
        $user->setEmail('jhyfy');
        $user->setEnabled(true);

        $userManager->updateUser($user);

        $this->addReference('customer', $user);
    }

    public function getOrder()
    {
        return 1;
    }
}