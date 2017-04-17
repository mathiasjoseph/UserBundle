<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Frontend;

use Miky\Bundle\LocationBundle\Form\Type\Frontend\LocationType;
use Miky\Bundle\OptionBundle\Form\DataTransformer\OptionTransformer;
use Miky\Bundle\OptionBundle\Form\Type\Frontend\UserPackageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationRequestType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('companyId', TextType::class, array('label'=> 'miky.ui.companyId'))
            ->add('companyName', TextType::class, array('label'=> 'miky.ui.companyName'))
            ->add('companyDescription', TextareaType::class, array('label'=> 'miky.ui.companyDescription', 'attr' => array('rows' => '14','cols' => '14')))
            ->add('activity', TextType::class)
            ->add('files', CollectionType::class, array(
                "entry_type" => 'miky_media_type',
                'entry_options' => array(
                    "context" => "certification_request",
                    "provider" => "miky.media.provider.file"
                ),
                "allow_add" => true,
                "allow_delete" => true
            ))
        ->add('location', LocationType::class)
            ->add('package', UserPackageType::class);
        ;
        $builder->get('package')->addModelTransformer(new OptionTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Miky\Bundle\UserBundle\Entity\CertificationRequest'
        ));
    }

    public function getName()
    {
        return 'miky_certification_request_frontend';
    }
}