<?php

namespace ESGaming\NewBundle\Controller;

use ESGaming\NewBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingNewBundle:News');
        $news       = $repository->findAll();

        return $this->render('ESGamingNewBundle:News:index.html.twig',array('news'=>$news));
    }

    public function addAction(Request $request)
    {
        $new = new News();
        $formBuilder = $this->get('form.factory')->createBuilder('form',$new);

        $formBuilder
            ->add('author','entity',array(
            'class'=>'ESGamingUserBundle:User',
            'property'=>'nickname','expanded'=>false,
            'multiple'=>false,'label'=>true))
            ->add('title','text')
            ->add('subtitle','text')
            ->add('text','textarea')
            ->add('mainBanner','text')
            ->add('status','integer')
            ->add('type','integer')
            ->add('Ajouter','submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($new);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'New bien enregistrée.');

            return $this->redirect($this->generateUrl('es_gaming_new_get', array('id' => $new->getId())));

        }

        return $this->render('ESGamingNewBundle:News:add.html.twig',array('form'=>$form->createView()));
    }

    public function newAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingNewBundle:New');
        $new        = $repository->find($id);

        if($new === null)
        {
            throw new NotFoundHttpException("L'annonce n°$id n'existe pas");
        }

        return $this->render('ESGamingNewBundle:News:new.html.twig',array('new'=>$new));
    }
}