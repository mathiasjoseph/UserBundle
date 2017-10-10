<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/09/17
 * Time: 19:07
 */

namespace Miky\Bundle\UserBundle\Mailer\PredefinedMail;


use Miky\Bundle\MailBundle\Model\BasePredefinedMailSchemaGroup;

class UserPredefinedSchema extends BasePredefinedMailSchemaGroup
{
    public static function getContexts(){
        return array(
            "miky_user_registration" => "getRegistrationSchema"
        );
    }

    public function getRegistrationSchema(){
        $schema = $this->createSchema();
        $schema->setLabel("miky_user.when_a_user_registers");
        return $schema;
    }
}