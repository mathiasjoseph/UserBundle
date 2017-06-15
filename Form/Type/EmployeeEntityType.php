<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/06/17
 * Time: 07:12
 */

namespace Miky\Bundle\UserBundle\Form\Type;


use Miky\Bundle\UserBundle\Model\Employee;
use Miky\Bundle\UserBundle\Model\User;
use Miky\Component\User\Model\UserInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeEntityType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * EmployeeEntityType constructor.
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->class,
            'choice_label' => function (Employee $employee) {
                if (!empty($employee->getFirstname()) && !empty($employee->getLastname())){
                    return $employee->getFirstname(). " " . $employee->getLastname();
                }else{
                    return $employee->getEmail();
                }
            }
        ));
    }

    
    public function getParent()
    {
        return EntityType::class;
    }
}