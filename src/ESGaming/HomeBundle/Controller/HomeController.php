<?php

namespace ESGaming\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        //c'est ici que les jeux seront appeler pour être envoyé à la vue
        return $this->render('ESGamingHomeBundle:Home:index.html.twig');
    }
}
