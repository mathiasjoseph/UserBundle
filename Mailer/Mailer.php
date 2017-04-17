<?php

namespace Miky\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;

class Mailer implements MailerInterface
{
    protected $mailer;
    protected $router;
    protected $templating;
    protected $parameters;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $url = $this->router->generate('miky_app_customer_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render("@MikyUser/Frontend/Mail/email.txt.twig", array(
            'user' => $user,
            'confirmationUrl' => $url,

        ));
        $this->sendEmailMessage($rendered, "no-reply@miky.com", $user->getEmail());
    }

    public function sendCertificationConfirmationMessage(UserInterface $user)
    {
       $rendered = $this->templating->render("@MikyUser/Frontend/Mail/certification_confirmation.txt.twig", array(
            'user' => $user,
        ));
        $this->sendEmailMessage($rendered, "no-reply@miky.com", $user->getEmail());
    }

    public function sendCertificationRequestMessage(UserInterface $user)
    {
       $rendered = $this->templating->render("@MikyUser/Frontend/Mail/certification_request.txt.twig", array(
            'user' => $user,

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

    /**
     * @param string $renderedTemplate
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $this->mailer->send($message);
    }
}
