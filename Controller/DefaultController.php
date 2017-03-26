<?php

namespace Miky\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MikyUserBundle:Default:index.html.twig');
    }
}
