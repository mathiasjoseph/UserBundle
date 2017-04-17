<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 07/12/16
 * Time: 08:01
 */

namespace Miky\Bundle\UserBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Miky\Bundle\OptionBundle\Util\DateOptionProvider;
use Miky\Bundle\OrderBundle\Entity\MikyOrder;
use Miky\Bundle\OrderBundle\Event\GetOrderResponseEvent;
use Miky\Bundle\OrderBundle\MikyOrderEvents;
use Miky\Bundle\UserBundle\Event\GetResponseCertificationEvent;
use Miky\Bundle\UserBundle\MikyUserEvents;
use Miky\Bundle\UserBundle\Transformer\TransformCertificationToOrder;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CertificationPaymentListener implements EventSubscriberInterface
{
    protected $em;

    protected $transformer;

    protected $router;

    protected $dateOption;

    /**
     * CommentAdListener constructor.
     */
    public function __construct(EntityManager $em, TransformCertificationToOrder $transformer, Router $router, DateOptionProvider $dateOption)
    {
        $this->em = $em;
        $this->transformer = $transformer;
        $this->router = $router;
        $this->dateOption = $dateOption;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MikyUserEvents::CERTIFICATION_REQUEST_COMPLETED => 'onRequest',
            MikyOrderEvents::ORDER_STATUS_PAID_COMPLETED => 'onPaymentSuccess',
            MikyOrderEvents::ORDER_STATUS_PENDING_COMPLETED => 'onPaymentPending',
            MikyOrderEvents::ORDER_STATUS_CANCEL_COMPLETED => 'onPaymentCancel',
        );
    }

    public function onRequest(GetResponseCertificationEvent $event)
    {
        $order = $this->transformer->transform($event->getCertificationRequest());
        if ($order->getAmount() > 0) {
            if ($event->getRequest()->request->get("payment_method") == "stripe") {
                $response = new RedirectResponse($this->router->generate('miky_app_payment_prepare_checkout_stripe', array(
                    "order" => $order->getId()), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
                $event->setResponse($response);
            }
            if ($event->getRequest()->request->get("payment_method") == "paypal") {
                $response = new RedirectResponse($this->router->generate('miky_app_payment_prepare_checkout_paypal', array(
                    "order" => $order->getId()), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
                $event->setResponse($response);

            }
        }
    }

    public function onPaymentSuccess(GetOrderResponseEvent $event)
    {
        if ($event->getOrder()->getCertificationRequest() != null) {
            $certificationRequest = $event->getOrder()->getCertificationRequest();
            if ($event->getOrder()->getState() == MikyOrder::SEESTOCK_ORDER_STATUS_PAID) {
                if ($certificationRequest->getPackage() != null) {
                    if (!$certificationRequest->getPackage()->getEnabled()) {
                        $certificationRequest->setPaid(true);
                    }
                }
                $this->em->persist($certificationRequest);
                $this->em->flush();
                $response = new RedirectResponse($this->router->generate('miky_app_ad_pending_validation', array("ad" => $event->getOrder()->getAd()), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
                $event->setResponse($response);
            }
        }
    }

    public function onPaymentPending(GetOrderResponseEvent $event)
    {
        if ($event->getOrder()->getCertificationRequest() != null) {
            $response = new RedirectResponse($this->router->generate('miky_app_ad_pending_validation', array("ad" => $event->getOrder()->getAd()), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
            $event->setResponse($response);
        }
    }

    public function onPaymentCancel(GetOrderResponseEvent $event)
    {

        if ($event->getOrder()->getCertificationRequest() != null) {
            $this->em->remove($event->getOrder()->getCertificationRequest());
            $this->em->flush();
            $response = new RedirectResponse($this->router->generate('miky_app_customer_certification_request', array(), UrlGeneratorInterface::ABSOLUTE_PATH), 302);
            $event->setResponse($response);
        }
    }
}