<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/06/17
 * Time: 14:41
 */

namespace Miky\Bundle\UserBundle\Twig;


use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserExtension extends \Twig_Extension
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('is_authenticated', array($this, 'isAuthenticated')),
            new \Twig_SimpleFunction('get_current_user', array($this, 'getCurrentUser'))
        );
    }

    public function isAuthenticated()
    {
        if (null === $this->getCurrentUser()) {
            return false;
        }else{
            return true;
        }
    }

    public function getCurrentUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            return null;
        }
        return $user;
    }
}