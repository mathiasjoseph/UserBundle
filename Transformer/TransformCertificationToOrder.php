<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 28/10/16
 * Time: 07:29
 */

namespace Miky\Bundle\UserBundle\Transformer;


use Doctrine\ORM\EntityManager;
use Miky\Bundle\OrderBundle\Entity\OrderItem;
use Miky\Bundle\OrderBundle\Manager\OrderManager;
use Miky\Bundle\UserBundle\Entity\CertificationRequest;

class TransformCertificationToOrder
{
    private $orderManager;

    private $em;

    public function __construct(OrderManager $orderManager, EntityManager $em)
    {
        $this->orderManager = $orderManager;
        $this->em = $em;
    }

    public function transform(CertificationRequest $certificationRequest){

        $order = $this->orderManager->createOrder();
        $order->setCustomer($certificationRequest->getCustomer());
        $order->setCertificationRequest($certificationRequest);
        if ($certificationRequest->getPackage() != null){
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $certificationRequest->getPackage()->setCertificationRequest($certificationRequest);
            $orderItem->setName($certificationRequest->getPackage()->getTemplate()->getName());
            $orderItem->setDescription($certificationRequest->getPackage()->getTemplate()->getName());
            $orderItem->setAmount($certificationRequest->getPackage()->getTemplate()->getPrice());
            $order->addItem($orderItem);
        }
        $order->recalculateAmount();
        $this->orderManager->updateOrder($order);
        $this->em->persist($certificationRequest);
        $this->em->flush();
        return $order;
    }
}