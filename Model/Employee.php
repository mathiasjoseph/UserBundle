<?php
/**
 * Created by PhpStorm.
 * User: MikyProg
 * Date: 06/08/2016
 * Time: 17:16
 */

namespace Miky\Bundle\UserBundle\Model;


use Miky\Component\Resource\Model\ResourceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"email", "username"})
 */
class Employee extends \Miky\Component\User\Model\Employee implements ResourceInterface
{
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}