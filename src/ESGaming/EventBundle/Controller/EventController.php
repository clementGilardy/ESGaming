<?php

namespace ESGaming\EventBundle\Controller;

use ESGaming\EventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESGamingEventBundle:Event:index.html.twig');
    }


    public function addAction(Request $request)
    {
        $event = new Event();
        $formBuilder = $this->get('form.factory')->createBuilder('form',$event);

        $formBuilder
            ->add('event','text')
            ->add('game','entity',array('class'=>'ESGamingGameBundle:Game',
                'property'=>'name','expanded'=>false,
                'multiple'=>false))
            ->add('text','textarea')
            ->add('Ajouter','submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Event bien enregistrée.');

            return $this->redirect($this->generateUrl('es_gaming_event_get', array('id' => $event->getId())));

        }

        return $this->render('ESGamingEventBundle:Event:add.html.twig',array('form'=>$form->createView()));
    }


    public function deleteAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $event = $em->getRepository('ESGamingEventBundle:Event')->find($id);


        if ($event == null) {
            throw $this->createNotFoundException("L'event d'id ".$id." n'existe pas.");
        }

        if ($request->isMethod('POST')) {


            $request->getSession()->getFlashBag()->add('info', 'Evenement bien supprimé.');


        }

        return $this->render('ESGamingEventBundle:Event:delete.html.twig', array(
            'event' => $event
        ));
    }



    public function displayAllAction()
{
    $em = $this->container->get('doctrine')->getEntityManager();

    $event= $em->getRepository('ESGamingEventBundle:Event')->findAll();

    return $this->render('ESGamingEventBundle:Event:displayAll.html.twig', array(
        'events' => $event
    ));
}


    public function displayOneAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $event= $em->getRepository('ESGamingEventBundle:Event')->find($id);

        if ($event == null) {
            throw $this->createNotFoundException("L'event d'id ".$id." n'existe pas.");
        }

        return $this->render('ESGamingEventBundle:Event:displayOne.html.twig', array(
            'event' => $event
        ));
    }

    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('ESGamingEventBundle:Event')->find($id);

        if ($event == null) {
            throw $this->createNotFoundException("L'event d'id ".$id." n'existe pas.");
        }

        return $this->render('ESGamingEventBundle:Event:edit.html.twig', array(
            'event' => $event
    ));
    }
}

?>
