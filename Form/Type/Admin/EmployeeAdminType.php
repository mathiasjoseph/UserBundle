<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/08/16
 * Time: 09:40
 */

namespace Miky\Bundle\UserBundle\Form\Type\Admin;

use Symfony\Component\Form\FormBuilderInterface;

class EmployeeAdminType extends BaseUserAdminType
{
    public function __construct($class)
    {
        parent::__construct($class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }
}