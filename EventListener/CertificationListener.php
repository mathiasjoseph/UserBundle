<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 23:01
 */

namespace Miky\Bundle\UserBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Miky\Bundle\OptionBundle\Util\DateOptionProvider;
use Miky\Bundle\UserBundle\Entity\CertificationRequest;
use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Event\CertificationEvent;
use Miky\Bundle\UserBundle\Mailer\Mailer;
use Miky\Bundle\UserBundle\MikyUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CertificationListener implements EventSubscriberInterface
{
    protected $mailer;

    protected $em;

    protected $dateOptionProvider;

    /**
     * CommentAdListener constructor.
     */
    public function __construct(Mailer $mailer, DateOptionProvider $dateOptionProvider, EntityManager $em)
    {
        $this->mailer = $mailer;
        $this->dateOptionProvider = $dateOptionProvider;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MikyUserEvents::CERTIFICATION_REQUEST_SUCCESS => 'onRequest',
            MikyUserEvents::CERTIFICATION_VALIDATION_COMPLETED => 'onValidation',
        );
    }

    public function onValidation(CertificationEvent $event)
    {
        /** @var CertificationRequest $certificationRequest */
        $certificationRequest = $event->getCertificationRequest();
        /** @var Customer $user */
        $user = $certificationRequest->getCustomer();
        if ($certificationRequest->getPackage()) {
            if ($certificationRequest->isPaid()) {
                $certificationRequest->getPackage()->setEnabled(true);
                $this->dateOptionProvider->setExpirationDate($certificationRequest->getPackage());
                $user->setCompanyId($certificationRequest->getCompanyId());
                $user->setCompanyDescription($certificationRequest->getCompanyDescription());
                $user->setCompanyName($certificationRequest->getCompanyName());
                $user->setCertified(true);
                $this->em->persist($user);
                $this->em->persist($certificationRequest);
                $this->em->flush();
            }
        }
        $this->mailer->sendCertificationConfirmationMessage($event->getCertificationRequest()->getCustomer());
    }

    public function onRequest(CertificationEvent $event)
    {
        $this->mailer->sendCertificationRequestMessage($event->getCertificationRequest()->getCustomer());
    }
}