<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/06/17
 * Time: 19:45
 */

namespace Miky\Bundle\UserBundle\Form\Type\Admin;


use Miky\Bundle\CoreBundle\Form\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseUserAdminType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', CheckboxType::class, array(
                "label" => "miky_core.enabled"
            ))
            ->add('email', EmailType::class, array(
                "label" => 'miky_core.email'
            ))
            ->add('lastname', TextType::class, array(
                "label" => 'miky_core.lastname',
                "required" => false,
            ))
            ->add('firstname', TextType::class, array(
                "label" => 'miky_core.firstname',
                "required" => false,
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                "required" => false,
            ))
            ->add('gender', ChoiceType::class, array(
                "choices" => array(
                    "miky_user.female" => "f",
                    "miky_user.male" => "m",),
                "label" => 'miky_user.gender',
                "required" => false,
            ))
            ->add('dateOfBirth', DateType::class, array(
                "label" => 'miky_user.date_of_birth',
                "required" => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

}