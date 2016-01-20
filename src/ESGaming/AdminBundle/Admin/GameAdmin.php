<?php

namespace ESGaming\AdminBundle\Admin;

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
            ->add('name',null,array('label' => 'Nom du Jeu'))
            ->add('editor',null,array('label' => 'Editeur'))
            ->add('developer',null,array('label' => 'Developpeur'))
            ->add('type',null,array('label' => 'Type'))
            ->add('desc_short','text',array('label' => 'Description courte'))
            ->add('desc_long','text',array('label' => 'Description longue'))
            ->add('release_date','datetime',array('label' => 'Date de sortie'))
            ->add('mark',null,array('label' => 'Note'))
            ->add('download_link','text',array('label' => 'Lien de téléchargement'))
            ->add('logo',null,array('label' => 'Logo'))
            ->add('banner',null,array('label' => 'Banniere'))
            ->add('trailer',null,array('label' => 'Trailer'));

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
            ->add('desc_short','text',array('label' => 'Description courte'))
            ->add('desc_long','text',array('label' => 'Description longue'))
            ->add('release_date','sonata_type_date_picker',array('label' => 'Date de Sortie',
                                                                    'format' => 'yyyy-MM-dd'))
            ->add('mark','choice',array('label' => 'Note','choices' => range(0,20)))
            ->add('support','choice',array('multiple' => true,
                                            'choices' => array(1 => 'PC', 2 => 'PS3', 3 => 'PS4', 4 => 'XBox 360', 5 => 'XBox One')))
            ->add('download_link','text',array('label' => 'Lien de téléchargement'))
            ->add('logo',null,array('label' => 'Logo'))
            ->add('classification','choice',array('choices' => array(1 => 'PEGI 3', 2 => 'PEGI 7', 3 => 'PEGI 12', 4 => 'PEGI 16', 5 => 'PEGI 18')))
            ->add('banner',null,array('label' => 'Banniere'))
            ->add('trailer',null,array('label' => 'Trailer'))
            ->add('post_date','sonata_type_datetime_picker',array('data' => new \DateTime('now'),'read_only' => true,'pattern' => 'yyyy-MM-dd H:i:s'));
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