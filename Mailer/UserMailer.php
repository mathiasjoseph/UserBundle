<?php

namespace Miky\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use Miky\Bundle\MailBundle\Mailer\AbstractMailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserMailer extends AbstractMailer
{
    public function __construct($mailer, RouterInterface $router, EngineInterface $templating)
    {
        parent::__construct($mailer, $router, $templating);
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $url = $this->router->generate("miky_user_front_registration_confirm", array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

        $rendered = $this->templating->render("@MikyUser/Mail/registration_confirm.html.twig", array(
            'user' => $user,
            'confirmationUrl' => $url,

        ));
        $this->sendEmailMessage($rendered, "no-reply@miky.com", $user->getEmail());
    }


    public function sendResettingEmailMessage(UserInterface $user)
    {
        $url = $this->router->generate('miky_app_customer_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render("@MikyUser/Frontend/Resetting/email.txt.twig", array(
            'user' => $user,
            'confirmationUrl' => $url
        ));
        $this->sendEmailMessage($rendered, "no-reply@miky.com", $user->getEmail());
    }


}
