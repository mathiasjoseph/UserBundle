<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04/07/17
 * Time: 09:41
 */

namespace Miky\Bundle\UserBundle\Form\Type;


use Miky\Component\User\Model\Traits\UserPersonInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("personType", ChoiceType::class,array(
                "choices" => array(
                    "miky_user.by_user" => UserPersonInterface::TYPE_USER,
                    "miky_user.by_employee" => UserPersonInterface::TYPE_EMPLOYEE,
                ),
                "casper_group" => "user_person",
                "casper_name" => "type",
                "casper_hide" => array(
                    UserPersonInterface::TYPE_USER => array(UserPersonInterface::TYPE_EMPLOYEE, UserPersonInterface::TYPE_CONTACT_SHEET),
                    UserPersonInterface::TYPE_EMPLOYEE => array(UserPersonInterface::TYPE_USER, UserPersonInterface::TYPE_CONTACT_SHEET),
                ),
                "casper_show" => array(
                    UserPersonInterface::TYPE_USER => array(UserPersonInterface::TYPE_USER),
                    UserPersonInterface::TYPE_EMPLOYEE => array(UserPersonInterface::TYPE_EMPLOYEE),
                )
            ))
            ->add('user', UserEntityType::class, array(
                "label" => "miky_user.user",
                "casper_group" => "user_person",
                "casper_name" => UserPersonInterface::TYPE_USER
            ))
            ->add('employee', EmployeeEntityType::class, array(
                "label" => "miky_user.employee",
                "casper_group" => "user_person",
                "casper_name" => UserPersonInterface::TYPE_EMPLOYEE
            ));
    }
}