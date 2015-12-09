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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $new = new News();
        $formBuilder = $this->get('form.factory')->createBuilder('form',$new);

        $formBuilder
            ->add('title','text')
            ->add('subtitle','text')
            ->add('text','textarea')
            ->add('file','file')
            ->add('status','entity',array('class'=>'ESGamingNewBundle:Status',
                'property'=>'name','expanded'=>false,
                'multiple'=>false))
            ->add('type','entity',array('class'=>'ESGamingNewBundle:Type',
                'property'=>'name','expanded'=>false,
                'multiple'=>false))
            ->add('Ajouter','submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $new->setAuthor($this->getUser());
            $new->upload();
            $em->persist($new);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'New bien enregistrée.');

            return $this->redirect($this->generateUrl('es_gaming_new_get', array('id' => $new->getId())));

        }

        return $this->render('ESGamingNewBundle:News:add.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingNewBundle:News');
        $new        = $repository->find($id);

        if($new === null)
        {
            throw new NotFoundHttpException("L'annonce n°$id n'existe pas");
        }

        return $this->render('ESGamingNewBundle:News:new.html.twig',array('new'=>$new));
    }
}