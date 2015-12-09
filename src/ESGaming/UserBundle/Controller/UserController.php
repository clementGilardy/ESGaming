<?php

namespace ESGaming\UserBundle\Controller;

use ESGaming\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ESGamingUserBundle:User:index.html.twig', array('name' => $name));
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $formBuilder = $this->get('form.factory')->createBuilder('form',$user);

        $formBuilder
            ->add('first_name','text')
            ->add('last_name','text')
            ->add('nickname','text')
            ->add('mail','text')
            ->add('password','text')
            ->add('picture','file')
            ->add('role','entity',array('class'=>'ESGamingUserBundle:Job',
                'property'=>'title','expanded'=>false,
                'multiple'=>false))
            ->add('secret_question','entity',array('class'=>'ESGamingUserBundle:Question',
                'property'=>'question','expanded'=>false,
                'multiple'=>false))
            ->add('secret_answer','text')
            ->add('Ajouter','submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

            return $this->redirect($this->generateUrl('es_gaming_user_get', array('id' => $user->getId())));

        }

        return $this->render('ESGamingUserBundle:User:add.html.twig',array('form'=>$form->createView()));
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user        = $repository->find($id);

        if($user === null)
        {
            throw new NotFoundHttpException("L'user n°$id n'existe pas");
        }

        return $this->render('ESGamingUserBundle:User:user.html.twig',array('user'=>$user));
    }

}
