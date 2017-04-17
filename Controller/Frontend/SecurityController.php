<?php

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use Miky\Bundle\UserBundle\Model\CustomerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request = null)
    {
        $request = $request === null ? $request = $this->get('request') : $request;

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($user instanceof CustomerInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->generateUrl('miky_app_home_index');

            return $this->redirect($url);
        }

        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error;
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);


        $csrfToken = $this->container->get('security.csrf.token_manager')->getToken('authenticate');


        return $this->render('MikyUserBundle:Frontend:Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'referer' => $request->get("referer") != null ? $request->get("referer") : $request->headers->get("referer"),
        ));
    }
}
