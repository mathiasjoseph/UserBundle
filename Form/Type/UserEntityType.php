<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/06/17
 * Time: 07:12
 */

namespace Miky\Bundle\UserBundle\Form\Type;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEntityType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * UserEntityType constructor.
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->class
        ));
    }



    public function getParent()
    {
        return EntityType::class;
    }
}