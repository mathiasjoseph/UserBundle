<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 09/10/16
 * Time: 10:46
 */

namespace Miky\Bundle\UserBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use Miky\Bundle\AdBundle\Entity\Ad;
use Miky\Bundle\AdBundle\Event\AdEvent;
use Miky\Bundle\AdBundle\MikyAdEvents;
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;


class FavoriteApiController extends FOSRestController
{
    public function addUserFavoriteAdAction(Request $request, Customer $user, Ad $ad)
    {
        $customerManager = $this->get('miky_customer_manager');
        if ($user != null) {
            if ($ad != null) {
                $user->addFavoriteAd($ad);
            }
        }
        $customerManager->updateUser($user);
        $event = new AdEvent($ad, $request);
        $this->get("event_dispatcher")->dispatch(MikyAdEvents::AD_CREATE_FAVORITE_COMPLETED, $event);
        $view = $this->view(true, 200);
        return $this->handleView($view);
    }

    public function removeUserFavoriteAdAction(Request $request, Customer $user, Ad $ad)
    {
        $customerManager = $this->get('miky_customer_manager');
        if ($user != null) {
            if ($ad != null) {
                $user->removeFavoriteAd($ad);
            }
        }
        $event = new AdEvent($ad, $request);
        $this->get("event_dispatcher")->dispatch(MikyAdEvents::AD_REMOVE_FAVORITE_COMPLETED, $event);
        $customerManager->updateUser($user);
        $view = $this->view(true, 200);
        return $this->handleView($view);
    }
}