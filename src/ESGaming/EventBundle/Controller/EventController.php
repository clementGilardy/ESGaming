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


    /**public function addAction()
    {
        $add = array(
            'titre'     =>"Titre de la news",
            'date'      =>new \DateTime(),
            'texte'   =>"Contenu de la news"
        );
        return $this->render('ESGamingEventBundle:Event:index.html.twig', array(
            'add'       => $add,
        ));

    }
}**/

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


    public function deleteAction($id)
    {
       /** $em = $this->container->get('doctrine')->getEntityManager();
        $event = $em->find('ESGamingEventBundle:Event', $id);

        $em->remove($event);
        $em->flush();


        return new RedirectResponse($this->container->get('router')->generate('es_gaming_event_delete'));**/

        $em = $this->getDoctrine()->getEntityManager();
        $guest = $em->getRepository('ESGamingEventBundle:Event')->find($id);

        if (!$guest) {
            throw $this->createNotFoundException('Rien trouvé pour cet id '.$id);
        }

        $em->remove($guest);
        $em->flush();

        return $this->redirect($this->generateUrl('ESGamingEventBundle:Event:delete.html.twig'));

    }



    public function displayAllAction()
{
    $em = $this->container->get('doctrine')->getEntityManager();

    $event= $em->getRepository('ESGamingEventBundle:Event')->findAll();

    return $this->container->get('templating')->renderResponse('ESGamingEventBundle:Event:index.html.twig',
        array(
            'event' => $event
        ));
}

    public function editAction($id = null)
{
    $message='';
    $em = $this->container->get('doctrine')->getEntityManager();

    if (isset($id))
    {

        $event = $em->find('ESGamingEventBundle:Event', $id);

        if (!$event)
        {
            $message='Aucun evenement trouvé';
        }
    }
    else
    {
        $event = new event();
    }

    $form = $this->container->get('form.factory')->create(new EventForm(), $event);

    $request = $this->container->get('request');

    if ($request->getMethod() == 'POST')
    {
        $form->bindRequest($request);

        if ($form->isValid())
        {
            $em->persist($event);
            $em->flush();
            if (isset($id))
            {
                $message='Evenement modifié avec succès !';
            }
            else
            {
                $message='Evenement ajouté avec succès !';
            }
        }
    }

    return $this->container->get('templating')->renderResponse(
        'ESGamingEventBundle:Event:index.html.twig',
        array(
            'form' => $form->createView(),
            'message' => $message,
        ));
}

}
?>
