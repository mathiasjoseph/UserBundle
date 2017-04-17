<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 06/03/17
 * Time: 12:24
 */

namespace Miky\Bundle\UserBundle\Mailer;


use Miky\Bundle\MailBundle\Mailer\AbstractMailer;
use Miky\Bundle\SettingsBundle\Manager\SettingsManager;
use Miky\Bundle\UserBundle\Entity\CertificationRequest;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;

class CertificationMailer extends AbstractMailer
{
    private $settingsManager;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating, SettingsManager $settingsManager)
    {
        parent::__construct($mailer, $router, $templating);
        $this->settingsManager = $settingsManager;
    }


    public function sendNewCertificationRequestEditedMessage(CertificationRequest $certificationRequest)
    {
        $rendered = $this->templating->render("@MikyUser/Mail/new_certification_request.txt.twig", array(
            'certification' => $certificationRequest,
        ));
        $this->sendEmailMessage($rendered, "no-reply@miky.com", $this->settingsManager->load("contact")->get("contact_email"));
    }
}