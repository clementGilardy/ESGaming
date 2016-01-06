<?php

namespace ESGaming\AdminBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class NewAdmin extends Admin
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
            ->addIdentifier('id',null,array('label' => 'Identifiant news'))
            ->add('title',null,array('label' => 'Titre'))
            ->add('subtitle',null,array('label' => 'Sous-Titre'))
            ->add('text',null,array('label' => 'Contenu'))
            ->add('main_banner','file',array('label' => 'Image'));

        $list->add('_action', 'actions', array(
            'actions' => $actions
        ));
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title',null,array('label' => 'Nom du Jeu'));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title');
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