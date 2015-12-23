<?php

namespace ESGaming\UserBundle\Controller;

use ESGaming\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EWZ\Bundle\RecaptchaBundle;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Security\Core\SecurityContext;




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
            ->add('password','repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Password fields do not match',
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password')
                )
            )
            ->add('picture','file')
            ->add('role','entity',array('class'=>'ESGamingUserBundle:Job',
                'property'=>'title','expanded'=>false,
                'multiple'=>false))
            ->add('secret_question','entity',array('class'=>'ESGamingUserBundle:Question',
                'property'=>'question','expanded'=>false,
                'multiple'=>false))
            ->add('secret_answer','text')
            ->add('recaptcha', 'ewz_recaptcha')
            ->add('Ajouter','submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $user->setActivate(true);
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


    public function userAllAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $userAll        = $repository->findAll();

        if($userAll === null)
        {
            throw new NotFoundHttpException("Aucun utilisateur enregistré");
        }

        return $this->render('ESGamingUserBundle:User:userAll.html.twig',array('users'=>$userAll));
    }

    public function userDesactivateAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user = $repository->find($id);

        if($user != null)
        {
            $user->setActivate(false);
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
        }


        return $this->render('ESGamingUserBundle:User:userDesactivate.html.twig',array('user'=>$user));

    }

    public function userActivateAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user = $repository->find($id);

        if($user != null)
        {
            $user->setActivate(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
        }


       return $this->render('ESGamingUserBundle:User:userActivate.html.twig',array('user'=>$user));


    }


    public function loginAction(Request $request)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('es_gaming_user_homepage:'));
        }
        $session = $request->getSession();
        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('ESGamingUserBundle:User:login.html.twig', array(
            // Valeur du précédent nom d'utilisateur entré par l'internaute
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}
