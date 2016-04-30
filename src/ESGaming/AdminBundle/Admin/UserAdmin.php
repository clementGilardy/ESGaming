<?php

namespace ESGaming\AdminBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use ESGaming\UserBundle\Entity\User;
use ESGaming\UserBundle\Entity\Role;


class UserAdmin extends Admin
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
            ->add('updateStatus')
            ->remove('create');
    }

    protected function configureListFields(ListMapper $list)
    {
        $actions = array();
        $actions['edit'] = array();

        $list
            ->addIdentifier('id',null,array('label' => 'Identifiant utilisateur'))
            ->add('first_name',null,array('label' => 'Prénom'))
            ->add('last_name',null,array('label' => 'Nom'))
            ->add('nickname',null,array('label' => 'Pseudo'))
            ->add('role',null,array('label' => 'Role','class' => 'ESGamingUserBundle/Entity/Job'))
            ->add('mail',null,array('label' => 'E-Mail'))
            ->add('activate',null,array('label' => 'Activé'));

        $list->add('_action', 'actions', array(
            'actions' => $actions
        ));
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('role','entity',array('label' => 'Role', 'class' => 'ESGamingUserBundle:Job', 'property' => 'title'))
            ->add('activate','choice',array('label' => 'Activer',
                'choices' => array(0 => 'Désactivé',1 => 'Activé')));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nickname');
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