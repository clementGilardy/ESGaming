<?php

namespace ESGaming\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESGamingHomeBundle:Home:index.html.twig');
    }
}
