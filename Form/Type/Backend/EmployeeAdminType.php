<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeAdminType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                "label" => 'miky.ui.email'
            ))
            ->add('lastname', TextType::class, array(
                "label" => 'miky.ui.lastname'
            ))
            ->add('firstname', TextType::class, array(
                "label" => 'miky.ui.firstname'
            ))
            ->add('gender', ChoiceType::class, array(
                "choices" => array(
                    "f" => "miky.ui.female",
                    "m" => "miky.ui.male"),
                "label" => 'miky.ui.gender'
            ))
            ->add('dateOfBirth', DateType::class, array(
                "label" => 'miky.ui.date_of_birth'
            ))
            ->add('profileImage', 'miky_media_type', array(
                "context" => "employee",
                "provider" => "miky.media.provider.image",
                "label" => "miky.ui.profile_image",
            ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\Employee'
        ));
    }

    public function getName()
    {
        return 'miky_employee_admin';
    }
}