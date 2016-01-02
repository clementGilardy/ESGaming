<?php

namespace ESGaming\GameBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class GameAdmin extends Admin
{
    /**
     * @var EntityManager
     */
    private $em;

    public function setEntityManager($entityManager)
    {
        $this->em = $entityManager;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('updateStatus');
    }

    protected function configureListFields(ListMapper $list)
    {
        $actions = array();
        $actions['edit'] = array();

        $list
            ->addIdentifier('id',null,array('label' => 'Identifiant jeu'))
            ->add('name',null,array('label' => 'Nom du jeu'))
            ->add('editor',null,array('label' => 'Editeur'))
            ->add('developer',null,array('label' => 'Developpeur'))
            ->add('type',null,array('label' => 'Type'));

        $list->add('_action', 'actions', array(
            'actions' => $actions
        ));
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name',null,array('label' => 'Nom du Jeu'))
            ->add('editor',null,array('label' => 'Editeur'))
            ->add('developer',null,array('label' => 'Developpeur'))
            ->add('type',null,array('label' => 'Type'))
            ->add('desc_short',null,array('label' => 'Description courte'))
            ->add('desc_long','text',array('label' => 'Description longue'))
            ->add('release_date',null,array('label' => 'Date de Sortie'))
            ->add('mark',null,array('label' => 'Note'))
            ->add('support',null,array('label' => 'Support'))
            ->add('download_link',null,array('label' => 'Lien de téléchargement'))
            ->add('logo',null,array('label' => 'Logo'))
            ->add('classification',null,array('label' => 'Classification'))
            ->add('banner',null,array('label' => 'Banniere'))
            ->add('trailer',null,array('label' => 'Trailer'));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }


//    public function createQuery($context = 'list')
//    {
//        $query = parent::createQuery($context);
//
//        $em = $query->getQueryBuilder()->getEntityManager();
//        $em->getFilters()->disable('softdeleteable');
//
//        return $query;
//    }
//
//    public function getObject($id)
//    {
//        $this->em->getFilters()->disable('softdeleteable');
//        return parent::getObject($id);
//    }

}