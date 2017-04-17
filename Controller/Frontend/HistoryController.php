<?php
/**
 * Created by PhpStorm.
 * User: MikyProg
 * Date: 06/08/2016
 * Time: 18:26
 */

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Entity\History;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HistoryController extends Controller
{

    public function listAction(Request $request)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }

        $history = $this->get("doctrine.orm.entity_manager")->getRepository(History::class)->findBy(array("user" => $customer), array('updatedAt' => 'DESC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $history,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('MikyUserBundle:Frontend/History:list.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    public function removeAction(Request $request, History $history)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }

        if ($history->getUser()->getId() == $customer->getId()){
            $this->get("miky_history_manager")->deleteHistory($history);
        }
        return $this->redirectToRoute("miky_app_customer_history_list");
    }




}