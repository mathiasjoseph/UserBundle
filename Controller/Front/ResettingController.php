<?php

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use Miky\Bundle\UserBundle\Model\CustomerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class ResettingController extends Controller
{
    const SESSION_EMAIL = 'fos_user_send_resetting_email/email';

    /**
     * Request reset user password: show form
     */
    public function requestAction()
    {
        return $this->render("@MikyUser/Frontend/Resetting/request.html.twig");
    }

    /**
     * Request reset user password: submit form and send email
     */
    public function sendEmailAction()
    {
        $username = $this->get('request')->request->get('username');

        /** @var $user CustomerInterface */
        $user = $this->get('miky_customer_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->render('@MikyUser/Frontend/Resetting/request.html.twig', array('invalid_username' => $username));
        }

        if ($user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->render('@MikyUser/Frontend/Resetting/passwordAlreadyRequested.html.twig');
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->get('session')->set(static::SESSION_EMAIL, $this->getObfuscatedEmail($user));
        $this->get('miky_bundle_user.mailer.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->get('router')->generate('miky_app_customer_resetting_check_email'));
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $session = $this->get('session');
        $email = $session->get(static::SESSION_EMAIL);
        $session->remove(static::SESSION_EMAIL);

        if (empty($email)) {
            return new RedirectResponse($this->get('router')->generate('miky_app_customer_resetting_request'));
        }

        return $this->render('MikyUserBundle:Frontend/Resetting:checkEmail.html.twig', array(
            'email' => $email,
        ));
    }

    /**
     * Reset user password
     */
    public function resetAction($token)
    {
        $user = $this->get('miky_customer_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if (!$user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
            return new RedirectResponse($this->get('router')->generate('fos_user_resetting_request'));
        }

        $form = $this->get('fos_user.resetting.form');
        $formHandler = $this->get('fos_user.resetting.form.handler');
        $process = $formHandler->process($user);

        if ($process) {
            $this->setFlash('fos_user_success', 'resetting.flash.success');
            $response = new RedirectResponse($this->getRedirectionUrl($user));
            $this->authenticateUser($user, $response);

            return $response;
        }

        return $this->render('@MikyUser/Frontend/Resetting/reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(CustomerInterface $user, Response $response)
    {
        try {
            $this->get('fos_user.security.login_manager')->loginUser(
                $this->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(CustomerInterface $user)
    {
        return $this->get('router')->generate('miky_app_profile_edit');
    }

    /**
     * Get the truncated email displayed when requesting the resetting.
     *
     * The default implementation only keeps the part following @ in the address.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getObfuscatedEmail(CustomerInterface $user)
    {
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
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
