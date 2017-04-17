<?php

namespace Miky\Bundle\UserBundle\Controller\Frontend;


use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    /**
     * @return Response|RedirectResponse
     *
     * @throws AccessDeniedException
     */
    public function changePasswordAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $this->createAccessDeniedException('This user does not have access to this section.');
        }
        $form = $this->get('fos_user.change_password.form');
        $formHandler = $this->get('fos_user.change_password.form.handler');
        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('fos_user_success', 'change_password.flash.success');
            return $this->redirect($this->getRedirectionUrl($user));
        }
        return $this->render(
            'SonataUserBundle:ChangePassword:changePassword.html.' . $this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }

    /**
     * @param UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->generateUrl('miky_app_profile_edit');
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
