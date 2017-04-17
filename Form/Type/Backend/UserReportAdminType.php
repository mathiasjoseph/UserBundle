<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Backend;

use Miky\Bundle\AdBundle\Entity\Ad;
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserReportAdminType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                "class" => Customer::class,
                'choice_label' => 'username',
                "label" => 'miky.ui.user',
                "attr" => array(
                    "disabled" => "disabled"
                )
            ))
            ->add('whistleblower', EntityType::class, array(
                "class" => Customer::class,
                'choice_label' => 'username',
                "label" => 'Dénoncer par',
                "attr" => array(
                    "disabled" => "disabled"
                )
            ))
            ->add('ad', EntityType::class, array(
                "class" => Ad::class,
                'choice_label' => 'title',
                "label" => 'miky.ui.ad',
                "attr" => array(
                    "disabled" => "disabled"
                )
            ))
            ->add('body', TextareaType::class)
            ->add('reason', ChoiceType::class, array(
                "choices" => array(
                    "fraud" => "miky.ui.fraud",
                    "duplicate_ad" => "miky.ui.duplicate_ad",
                    "wrong_category" => "miky.ui.wrong_category",
                    "already_sold" => "miky.ui.already_sold",
                    "vulgarity" => "miky.ui.vulgarity",
                    "other_abuse" => "miky.ui.other_abuse",
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\UserReport'
        ));
    }

    public function getName()
    {
        return 'miky_user_report_admin';
    }
}