<?php

namespace ESGaming\GameBundle\Controller;

use ESGaming\GameBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingGameBundle:Game');
        $games       = $repository->findAll();

        return $this->render('ESGamingGameBundle:Game:index.html.twig',array('games'=>$games));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request,$id = null)
    {
        $label = "Ajouter";
        $game = new Game();

        if($id != null){
            $id = (int)trim($id);
            if(is_numeric($id)){
                $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingGameBundle:Game');
                $game = $repository->find($id);
                $label = "Modifier";
            }
        }

        $formBuilder = $this->get('form.factory')->createBuilder('form',$game);

        $formBuilder
            ->add('name','text')
            ->add('editor','text')
            ->add('developer','text')
            ->add('type','text')
            ->add('desc_short','ckeditor')
            ->add('desc_long','ckeditor')
            ->add('release_date','date_picker')
            ->add('mark','choice',array('label' => 'Note','choices' => range(0,20)))
            ->add('support','choice',array('multiple' => true,
                                            'choices' => array(1 => 'PC', 2 => 'PS3', 3 => 'PS4', 4 => 'XBox 360', 5 => 'XBox One')))
            ->add('download_link','text')
            ->add('logo','file',array('label' => 'Logo', 'data_class' => null))
            ->add('classification','choice',array('choices' => array(1 => 'PEGI 3', 2 => 'PEGI 7', 3 => 'PEGI 12', 4 => 'PEGI 16', 5 => 'PEGI 18')))
            ->add('banner','file',array('label' => 'Banniere', 'data_class' => null))
            ->add('trailer',null,array('label' => 'Trailer'))
            ->add($label,'submit');

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $game->upload();
            $em->persist($game);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Jeu bien enregistré.');

            return $this->redirect($this->generateUrl('es_gaming_new_get', array('id' => $game->getId())));

        }

        return $this->render('ESGamingGameBundle:Game:add.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gameAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingGameBundle:Game');
        $game      = $repository->find($id);

        if($game === null) {
            throw new NotFoundHttpException("Le jeu n°$id n'existe pas");
        }

        return $this->render('ESGamingGameBundle:Game:game.html.twig',array('game'=>$game));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteAction($id)
    {
        if(isset($id) && !empty($id)){
            $em         = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getManager()->getRepository('ESGamingGameBundle:Game');
            $game        = $repository->find($id);

            if(isset($game) && !empty($game)) {
                $em->remove($game);
                $em->flush();
            }
        }


        return $this->render('ESGamingGameBundle:Game:index.html.twig');
    }
}
