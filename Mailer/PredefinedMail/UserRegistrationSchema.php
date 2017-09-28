<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/09/17
 * Time: 19:07
 */

namespace Miky\Bundle\UserBundle\Mailer\PredefinedMail;


use Miky\Bundle\MailBundle\Model\PredefinedMailSchemaInterface;

class UserRegistrationSchema implements PredefinedMailSchemaInterface
{
    /**
     * @return string
     */
    public function getName(){
        return "h";
    }

    /**
     * @return string
     */
    public function getDefaultBody(){
        return "h";
    }

    /**
     * @return string
     */
    public function getDefaultSubject(){
        return "h";
    }

    /**
     * @return array
     */
    public function getVariables(){
        return "h";
    }

    /**
     * @return string
     */
    public function getDescription(){
        return "h";
    }
}