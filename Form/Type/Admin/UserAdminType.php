<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Admin;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminType extends AbstractType
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
                ->add('email', EmailType::class, array(
                    "label" => 'miky_core.email'
                ))
                ->add('lastname', TextType::class, array(
                    "label" => 'miky_core.lastname'
                ))
                ->add('firstname', TextType::class, array(
                    "label" => 'miky_core.firstname'
                ))
                ->add('gender', ChoiceType::class, array(
                    "choices" => array(
                        "miky_user.female" => "f",
                        "miky_user.male" => "m",),
                    "label" => 'miky.ui.gender'
                ))
                ->add('dateOfBirth', DateType::class, array(
                    "label" => 'miky.ui.date_of_birth'
                ));
//            ->add('profileImage', 'miky_media_type', array(
//                "context" => "customer",
//                "provider" => "miky.media.provider.image",
//                "mapped" => true,
//                "label" => "Photo de profil"
//            ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\Customer'
        ));
    }
}