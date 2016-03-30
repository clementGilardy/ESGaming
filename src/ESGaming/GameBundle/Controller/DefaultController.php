<?php

namespace ESGaming\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESGamingGameBundle:Default:index.html.twig');
    }
}
