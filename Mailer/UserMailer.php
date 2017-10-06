<?php

namespace Miky\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use Miky\Bundle\MailBundle\Mailer\AbstractMailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserMailer extends AbstractMailer
{
    protected $parameters;
    protected $mail;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating, $translator, $mail)
    {
        parent::__construct($mailer, $router, $templating, $translator);
        $this->mail = $mail;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $url = $this->router->generate('seestock_app_customer_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render("@MikyUser/Mail/registration_confirm.html.twig", array(
            'user' => $user,
            'confirmationUrl' => $url,

        ));
        $subject = $this->translator->trans("registration.email.subject",
            array("%username%" => $user->getUsername(), "%confirmationUrl%" => $url),
            'FOSUserBundle'
        );
        $this->sendEmailMessage($rendered, $this->mail, $user->getEmail(), $subject);
    }


    public function sendResettingEmailMessage(UserInterface $user)
    {
        $url = $this->router->generate('seestock_app_customer_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render("@SeestockApp/Front/User/Resetting/email.html.twig", array(
            'user' => $user,
            'confirmationUrl' => $url
        ));
        $subject = $this->translator->trans("resetting.email.subject",
            array("%username%" => $user->getUsername(), "%confirmationUrl%" => $url),
            'FOSUserBundle'
        );
        $this->sendEmailMessage($rendered, $this->mail, $user->getEmail(), $subject);
    }

}
