<?php

namespace Miky\Bundle\UserBundle\Controller\Frontend;

use Miky\Bundle\AdBundle\Entity\Ad;
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FavoriteController extends Controller
{
    /**
     * @return Response|RedirectResponse
     *
     * @throws AccessDeniedException
     */
    public function listFavoriteAdsAction()
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_home_index");
        }

        return $this->render('MikyUserBundle:Frontend/Favorite:list.html.twig', array(
            'ads' => $customer->getFavoriteAds(),
        ));
    }

    /**
     * @return Response|RedirectResponse
     *
     * @throws AccessDeniedException
     */
    public function removeFavoriteAdAction(Ad $ad)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_home_index");
        }
        $customer->removeFavoriteAd($ad);
        $this->get("miky_customer_manager")->updateUser($customer);
        return $this->redirectToRoute("miky_app_favorite_ads_list");
    }


}
