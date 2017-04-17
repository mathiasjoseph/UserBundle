<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 05/10/16
 * Time: 08:16
 */

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use Miky\Bundle\AdBundle\Entity\Ad;
use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Entity\UserReport;
use Miky\Bundle\UserBundle\Form\Type\Frontend\UserReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserReportController extends Controller
{

    public function reportOnAdAction(Request $request, Ad $ad)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }
        $report = new UserReport();
        $report->setAd($ad);
        $report->setType(UserReport::AD_REPORT);
        $report->setWhistleblower($customer);
        $form = $this->createForm(UserReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $report = $form->getData();

            $em = $this->get("doctrine.orm.entity_manager");
            $em->persist($report);
            $em->flush();
            $this->addFlash('success_report', 'report_success');

            return $this->redirectToRoute('miky_app_ad_show', array("ad" => $ad->getId()));
        }

        return $this->redirectToRoute('miky_app_ad_show', array("ad" => $ad->getId()));
    }


}