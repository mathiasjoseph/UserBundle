<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Backend;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerAdminType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', EmailType::class, array(
                "label" => "miky.ui.username"
            ))
            ->add('certified', CheckboxType::class, array(
                "label" => "miky.ui.certified"
            ))
            ->add('activity', TextType::class)
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('phone', TextType::class)
            ->add('facebook', TextType::class)
            ->add('twitter', TextType::class)
            ->add('linkedin', TextType::class)
            ->add('profileImage', 'miky_media_type', array(
                "context" => "customer",
                "provider" => "miky.media.provider.image",
                "mapped" => true,
                "label" => "Photo de profil"
            ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\Customer'
        ));
    }

    public function getName()
    {
        return 'miky_customer_admin';
    }
}