<?php

namespace ESGaming\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ESGamingHomeBundle:Default:index.html.twig', array('name' => $name));
    }
}
