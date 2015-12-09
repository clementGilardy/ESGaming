<?php

namespace ESGaming\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ESGamingCommentBundle:Default:index.html.twig', array('name' => $name));
    }
}
