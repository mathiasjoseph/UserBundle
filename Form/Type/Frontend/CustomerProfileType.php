<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Frontend;


use Miky\Bundle\LocaleBundle\Manager\LanguageManager;
use Miky\Bundle\LocationBundle\Form\Type\Frontend\LocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerProfileType extends AbstractType
{

    private $languageManager;

    /**
     * AdType constructor.
     */
    public function __construct(LanguageManager $languageManager)
    {
        $this->languageManager = $languageManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', TextType::class)
            ->add('username', TextType::class)
            ->add('activity', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                "required" => false
            ))
            ->add('languagesSpoken', ChoiceType::class, array(
                'choices' => $this->languageManager->getArrayAllIsoByName(),
                'multiple' => true,
                'expanded' => false,

            ))
            ->add('companyName', TextType::class)
            ->add('companyId', TextType::class)
            ->add('companyDescription', TextareaType::class, array('attr' => array('rows' => '15','cols' => '14')) )
            ->add('mobile', TextType::class)
            ->add('website', TextType::class)
            ->add('location', LocationType::class)
            ->add('phone', TextType::class)
            ->add('facebook', TextType::class)
            ->add('twitter', TextType::class)
            ->add('linkedin', TextType::class)
            ->add('profileImage', 'miky_media_type', array(
                'provider' => 'miky.media.provider.image',
                'context'  => 'customer'
            ))
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\Customer'
        ));
    }

    public function getName()
    {
        return 'miky_customer_profile_front';
    }
}