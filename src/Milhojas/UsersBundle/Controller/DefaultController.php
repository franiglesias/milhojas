<?php

namespace Milhojas\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MilhojasUsersBundle:Default:index.html.twig');
    }
}
