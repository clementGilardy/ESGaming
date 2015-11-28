<?php

namespace ESGaming\NewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESGamingNewBundle:News:index.html.twig');
    }

    public function newAction($id)
    {
        return $this->render('ESGamingNewBundle:News:new.html.twig',array('id'=>$id));
    }
}