<?php

namespace ESGaming\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingGameBundle:Game');
        $games      = $repository->findAll();

        return $this->render('ESGamingHomeBundle:Home:index.html.twig',array('games'=>$games));
    }
}
