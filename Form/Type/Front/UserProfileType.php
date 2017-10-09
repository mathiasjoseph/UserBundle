<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Front;


use Miky\Bundle\LocaleBundle\Manager\LanguageManager;
use Miky\Bundle\LocationBundle\Form\Type\Frontend\LocationType;
use Miky\Bundle\LocationBundle\Form\Type\GoogleGeocodingType;
use Miky\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                "label" => 'miky_core.firstname',
                "required" => false
            ))
            ->add('lastname', TextType::class, array(
                "label" => 'miky_core.lastname',
                "required" => false
            ))
            ->add('phone', TextType::class, array(
                "label" => 'miky_core.phone',
                "required" => false
            ))
            ->add('email', EmailType::class, array(
                "label" => 'miky_core.email',
                "disabled" => true
            ))
        ;
    }
}