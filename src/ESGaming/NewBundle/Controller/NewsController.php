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
    public function addAction(Request $request,$id = null)
    {
        $label = "Ajouter";
        $new = new News();

        if($id != null){
            $id = (int)trim($id);
            if(is_numeric($id)){
                $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingNewBundle:News');
                $new = $repository->find($id);
                $label = "Modifier";
            }
        }

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
            ->add($label,'submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $new->setAuthor($this->container->get('security.context')->getToken()->getUser());
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

        $news       = $repository->findByType(1);

        if($new === null) {
            throw new NotFoundHttpException("L'annonce n°$id n'existe pas");
        }

        return $this->render('ESGamingNewBundle:News:new.html.twig',array('new'=>$new,'news'=>$news));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteAction($id)
    {
        if(isset($id) && !empty($id)){
            $em         = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingNewBundle:News');
            $new        = $repository->find($id);

            if(isset($new) && !empty($new)) {
                $em->remove($new);
                $em->flush();
            }
        }


        return $this->render('ESGamingNewBundle:News:index.html.twig');
    }
}