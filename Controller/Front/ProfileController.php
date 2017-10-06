<?php

namespace Miky\Bundle\UserBundle\Controller\Front;

use FOS\UserBundle\Model\UserInterface;
use Miky\Bundle\UserBundle\Entity\Customer;
use Miky\Bundle\UserBundle\Model\User;
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
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof User) {
            return $this->redirectToRoute("miky_user_front_security_login");
        }

        $userManager = $this->container->get('miky_user.user_manager');

        $formFactory = $this->get('miky_user.profile.form.factory');
        $form = $formFactory->createForm($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userManager->updateUser($user);
        }

        return $this->render('MikyUserBundle:Front/Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
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
