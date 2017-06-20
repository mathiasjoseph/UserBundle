<?php

namespace Miky\Bundle\UserBundle\Controller\Frontend;

use FOS\UserBundle\Model\UserInterface;
use Miky\Bundle\UserBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends Controller
{
    /**
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('This user does not have access to this section.');
        }
        return $this->render('SonataUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'blocks' => $this->container->getParameter('sonata.user.configuration.profile_blocks'),
        ));
    }



    /**
     * @return Response|RedirectResponse
     *
     * @throws AccessDeniedException
     */
    public function editProfileAction(Request $request)
    {
        $customer = $this->getUser();
        if (!is_object($customer) || !$customer instanceof Customer) {
            return $this->redirectToRoute("miky_app_customer_security_login");
        }

        $customerManager = $this->container->get('miky_customer_manager');
        $customerManager->getRepository()->findOneById($customer->getId());
        $form = $this->createForm('miky_customer_profile_front', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $customerManager->updateUser($user);
        }

        return $this->render('MikyUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->getFlashBag()->set($action, $value);
    }
}
