<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 21/08/16
 * Time: 21:36
 */

namespace Miky\Bundle\UserBundle\Controller\Admin;


use Miky\Bundle\UserBundle\Model\EmployeeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{
    public function loginAction(Request $request = null)
    {
        $request = $request === null ? $request = $this->get('request') : $request;

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($user instanceof EmployeeInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->generateUrl('miky_admin_dashboard');

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
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        if ($this->has('security.csrf.token_manager')) { // sf >= 2.4
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate');
        } else {
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }


        return $this->render('MikyUserBundle:Backend:Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken
        ));
    }
}