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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ESGaming\UserBundle\Form\ChangePasswordType;
use ESGaming\UserBundle\Form\Model\ChangePassword;




class UserController extends Controller
{
    public function indexAction($user)
    {
        return $this->render('ESGamingUserBundle:User:index.html.twig', array('user' => $user));
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $formBuilder = $this->get('form.factory')->createBuilder('form', $user);

        $formBuilder
            ->add('first_name', 'text', array(
                'label' => 'Prénom'
            ))
            ->add('last_name', 'text',array('label'=>'Nom'))
            ->add('nickname', 'text',array('label'=>'Pseudo'))
            ->add('birthDate', 'date', array('widget'=>'choice',
                'label' => 'Date de Naissance',
                'input'=>'timestamp',
                'format' => 'd/M/y',
                'years' => range(date('Y')-100,date('Y')-10)))
            ->add('mail', 'text')
            ->add('password', 'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Password fields do not match',
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Confirmation du Password')
                )
            )
            ->add('picture', 'file',array('label'=>'Avatar'))
            ->add('secret_question', 'entity', array('class' => 'ESGamingUserBundle:Question',
                'property' => 'question', 'expanded' => false,
                'multiple' => false,'label'=>'Question secrète'))
            ->add('secret_answer', 'text',array('label'=>'Réponse secrète'))
            ->add('recaptcha', 'ewz_recaptcha')
            ->add('Ajouter', 'submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
            $user->setPassword($password);

            $user->setRole(2);

            $user->setActivate(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

            return $this->redirect($this->generateUrl('es_gaming_user_get', array('id' => $user->getId())));

        }

        return $this->render('ESGamingUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user = $repository->find($id);

        if ($user === null) {
            throw new NotFoundHttpException("L'user n°$id n'existe pas");
        }

        return $this->render('ESGamingUserBundle:User:user.html.twig', array('user' => $user));
    }


    public function userAllAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $userAll = $repository->findAll();

        if ($userAll === null) {
            throw new NotFoundHttpException("Aucun utilisateur enregistré");
        }

        return $this->render('ESGamingUserBundle:User:userAll.html.twig', array('users' => $userAll));
    }

    public function userDesactivateAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user = $repository->find($id);

        if ($user != null) {
            $user->setActivate(false);
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
        }


        return $this->render('ESGamingUserBundle:User:userDesactivate.html.twig', array('user' => $user));

    }

    public function userActivateAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingUserBundle:User');
        $user = $repository->find($id);

        if ($user != null) {
            $user->setActivate(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
        }


        return $this->render('ESGamingUserBundle:User:userActivate.html.twig', array('user' => $user));


    }


    /**
     * @Method({"GET"})
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('es_gaming_user_homepage:'));
        }

        $request = $this->getRequest();
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
            'error' => $error,
        ));
    }

    /**
     * @Method({"POST"})
     * @Route("/login_check", name="login_check")
     */
    public function check()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Method({"GET"})
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }


    public function editProfileAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $formBuilder = $this->get('form.factory')->createBuilder('form', $user);

        $formBuilder
            ->add('first_name', 'text', array(
                'label' => 'Prenom'
            ))
            ->add('last_name', 'text', array(
                'label' => 'Nom'))
            ->add('nickname', 'text', array(
                'label' => 'Pseudo'))
            ->add('lol_nickname', 'text', array(
                'label' => 'Pseudo League Of Legends'))
            ->add('steam_nickname', 'text', array(
                'label' => 'Pseudo Steam'))
            ->add('origin_nickname', 'text', array(
                'label' => 'Pseudo Origin'))
            ->add('birth_date', 'date', array(
                'label' => 'Date de Naissance',
                'format' => 'dd MMMM yyyy',
                'years' => range(date('Y')-100,date('Y')-10) ))
            ->add('mail', 'text')
           /* ->add('password', 'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Password fields do not match',
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Repetez votre mot de passe')
                )
            )*/
          //  ->add('picture', 'file')
            ->add('secret_question', 'entity', array('class' => 'ESGamingUserBundle:Question',
                'property' => 'question', 'expanded' => false,
                'multiple' => false))
            ->add('secret_answer', 'text')
            ->add('Modifier', 'submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Profil modifie avec succes.');

            return $this->redirect($this->generateUrl('es_gaming_user_profile', array('id' => $user->getId())));

        }

        return $this->render('ESGamingUserBundle:User:editProfile.html.twig', array('form' => $form->createView()));
    }

    public function changePasswordAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

        $form->handleRequest($request);

        /*$formBuilder
            ->add('oldPassword', 'password')
            ->add('newPassword', 'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Password fields do not match',
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Repetez votre mot de passe')
                )
            )
            ->add('Modifier le mot de passe', 'submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);*/

        $oldPassword = $form["oldPassword"]->getData();

        print_r($oldPassword);

        if ($form->isValid()) {
            print_r($user->getPassword());
            if($oldPassword == $user->getPassword()){
               print_r('oui');
            }
            /*$em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Profil modifie avec succes.');

            return $this->redirect($this->generateUrl('es_gaming_user_change_password', array('id' => $user->getId())));
            */
        }

        return $this->render('ESGamingUserBundle:User:changePassword.html.twig', array('form' => $form->createView()));
    }


    public function profileAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('ESGamingUserBundle:User:profile.html.twig', array('user' => $user));
    }

}
