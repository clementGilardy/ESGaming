<?php

namespace ESGaming\NewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESGamingNewBundle:News:index.html.twig');
    }
}