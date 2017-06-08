<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Backend;

use Miky\Bundle\LocationBundle\Form\Type\Backend\LocationAdminType;
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationRequestAdminType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class, array(
                "class" => Customer::class,
                'choice_label' => 'username',
                "attr" => array(
                    "disabled" => "disabled",
                )
            ))
            ->add('files', CollectionType::class, array(
                "entry_type" => 'miky_media_type',
                'entry_options' => array(
                    "context" => "certification_request",
                    "provider" => "miky.media.provider.file"
                ),

            ))
            ->add('paid', CheckboxType::class, array(
                "label" => "miky.order.status.paid",
                "attr" => array(
                    "disabled" => "disabled",
                )
            ))
            ->add('companyId', TextType::class, array('label'=> 'miky.ui.companyId'))
            ->add('comment', TextareaType::class, array('label'=> 'miky.ui.description'))
            ->add('location', LocationAdminType::class, array('label'=> 'miky.ui.location'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\CertificationRequest'
        ));
    }

    public function getName()
    {
        return 'miky_certification_request_admin';
    }
}