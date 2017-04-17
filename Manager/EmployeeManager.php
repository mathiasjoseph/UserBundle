<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 17/08/16
 * Time: 11:52
 */

namespace Miky\Bundle\UserBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class EmployeeManager extends UserManager
{

    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface $usernameCanonicalizer
     * @param CanonicalizerInterface $emailCanonicalizer
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);

    }
}