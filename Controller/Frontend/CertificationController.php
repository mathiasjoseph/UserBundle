<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 31/08/16
 * Time: 00:20
 */

namespace Miky\Bundle\UserBundle\Controller\Frontend;



use Miky\Bundle\OptionBundle\Entity\PackageTemplate;
use Miky\Bundle\UserBundle\Entity\CertificationRequest;
use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Event\CertificationEvent;
use Miky\Bundle\UserBundle\Event\GetResponseCertificationEvent;
use Miky\Bundle\UserBundle\Form\Type\Frontend\CertificationRequestType;
use Miky\Bundle\UserBundle\MikyUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CertificationController extends Controller
{
    public function requestAction(Request $request)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $certificationRequest = $em->getRepository(CertificationRequest::class)->findOneBy(array("customer" => $customer, "pendingValidation" => true));

        if ($certificationRequest != null){
            return $this->redirectToRoute("miky_app_customer_certification_pending");
        }

        $certificationRequest = new CertificationRequest();
        $certificationRequest->setCompanyName($customer->getCompanyName());
        $certificationRequest->setCompanyDescription($customer->getCompanyDescription());
        $certificationRequest->setCompanyId($customer->getCompanyId());
        $certificationRequest->setLocation($customer->getLocation());
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createForm(CertificationRequestType::class, $certificationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $certificationRequest = $form->getData();
            $certificationRequest->setCustomer($customer);
            $certificationRequest->setPendingValidation(true);
            $em->persist($certificationRequest);
            $em->flush();
            $this->get("miky_certification_mailer")->sendNewCertificationRequestEditedMessage($certificationRequest);

            $event = new CertificationEvent($certificationRequest, $request);
            $this->get("event_dispatcher")->dispatch(MikyUserEvents::CERTIFICATION_REQUEST_SUCCESS, $event);

            $response = $this->redirectToRoute("miky_app_customer_certification_pending");
            $event = new GetResponseCertificationEvent($certificationRequest, $response, $request);
            $this->get("event_dispatcher")->dispatch(MikyUserEvents::CERTIFICATION_REQUEST_COMPLETED, $event);
            return $event->getResponse();

        }
        return $this->render('MikyUserBundle:Frontend/Certification:request.html.twig', array(
            'form' => $form->createView(),
            "packages" => $this->get("doctrine.orm.entity_manager")
                ->getRepository(PackageTemplate::class)
                ->findBy(array("enabled" => true))
        ));
    }

    public function pendingAction(Request $request)
    {

        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $certificationRequest = $em->getRepository(CertificationRequest::class)->findOneBy(array("customer" => $customer, "pendingValidation" => true));
        if ($certificationRequest == null){
           return $this->redirectToRoute("miky_app_customer_certification_request");
        }

        return $this->render('MikyUserBundle:Frontend/Certification:pending.html.twig', array(
            'certificationRequest' => $certificationRequest,
        ));
    }

    public function removeAction(CertificationRequest $certificationRequest, Request $request)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $certificationRequest = $em->getRepository(CertificationRequest::class)->findOneBy(array("customer" => $customer, "pendingValidation" => true));
        if ($certificationRequest == null){
            return $this->redirectToRoute("miky_app_customer_certification_request");
        }else{
            $em->remove($certificationRequest);
            $em->flush();
        }

        return $this->redirectToRoute("miky_app_customer_certification_request");
    }
}