<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 22/08/16
 * Time: 22:40
 */

namespace Miky\Bundle\UserBundle\Controller\Front;

use FOS\UserBundle\Model\UserInterface;
use Miky\Bundle\NewsletterBundle\Entity\NewsletterSubscriber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class RegistrationController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function registerAction()
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            return $this->redirect($this->generateUrl('miky_app_profile_edit'));
        }
        $form = $this->get('sonata.user.registration.form')->add("newsletter", CheckboxType::class, array(
            "mapped" => false,
            "required" => false,
            "data" => true,
        ));
        $formHandler = $this->get('miky_user.registration_customer.form.handler');

        $process = $formHandler->process();
        if ($process) {
            $user = $form->getData();
            $authUser = false;
            if ($form->get("newsletter")->getData()){
                if ($user->getEmail() != null){
                    $subscriber = new NewsletterSubscriber();
                    $subscriber->setEmail($user->getEmail());
                    $em = $this->get("doctrine.orm.entity_manager");
                    $repository = $em->getRepository(NewsletterSubscriber::class);
                    if ($repository->findOneBy(array("email" => $subscriber->getEmail())) == null){
                        $em->persist($subscriber);
                        $em->flush();
                        $this->addFlash('success', 'miky.ui.newsletter_subscribe_success');
                    }else{
                        $this->addFlash('success', 'miky.ui.newsletter_subscribe_yet');
                    }
                }
            }
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $url = $this->generateUrl('miky_app_customer_registration_check_email');

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $response = new RedirectResponse($url);
            if ($authUser) {
                $this->authenticateUser($user, $response);
            }
            return $response;
        }
        $this->get('session')->set('sonata_user_redirect_url', $this->get('request')->headers->get('referer'));
        return $this->render('@MikyUser/Frontend/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Tell the user to check his email provider.
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }
        return $this->render('@MikyUser/Frontend/Registration/checkEmail.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param string $token
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException
     */
    public function confirmAction($token)
    {
        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        $response = $this->redirect($this->generateUrl('miky_app_customer_registration_confirmed'));

        $this->authenticateUser($user, $response);
        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     *
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('This user does not have access to this section.');
        }
        return $this->render("@MikyUser/Frontend/Registration/confirmed.html.twig", array(
            'user' => $user,
        ));
    }

    /**
     * Authenticate a user with Symfony Security.
     *
     * @param UserInterface $user
     * @param Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->getFlashBag()->set($action, $value);
    }

    /**
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
}