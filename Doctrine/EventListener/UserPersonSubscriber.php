<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 18/08/16
 * Time: 22:02
 */

namespace Miky\Bundle\UserBundle\Doctrine\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Miky\Component\User\Model\Traits\UserPersonInterface;


class UserPersonSubscriber implements EventSubscriber
{
    /**
     * @var string
     */
    private $userClass;

    /**
     * @var string
     */
    private $employeeClass;

    /**
     * UserPersonSubscriber constructor.
     */
    public function __construct($userClass, $employeeClass)
    {
        $this->userClass = $userClass;
        $this->employeeClass = $employeeClass;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();
        if (!in_array(UserPersonInterface::class, class_implements($metadata->getName()))) {
            return;
        }
        if (strpos($metadata->getName(), 'Entity') == false) {
           return;
        }
        $builder = new ClassMetadataBuilder($metadata);
        $builder->addField("personType", "string", array("length"=>"180"));
        $builder
            ->createManyToOne("user", $this->userClass)
            ->build();
        $builder
            ->createManyToOne("employee", $this->employeeClass)
            ->build();
    }


}