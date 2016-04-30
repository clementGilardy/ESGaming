<?php

namespace ESGaming\AdminBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use ESGaming\NewBundle\Entity\News;


class NewAdmin extends Admin
{
    /**
     * @var EntityManager
     */
    private $em;

    public function toString($object)
    {
        return $object instanceof News
            ? $object->getTitle()
            : 'Nouvelle News'; // shown in the breadcrumb on the create view
    }

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
            ->add('text','ckeditor',array('label' => 'Contenu'))
            ->add('main_banner','file',array('label' => 'Image', 'data_class' => null));

        $list->add('_action', 'actions', array(
            'actions' => $actions
        ));
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title',null,array('label' => 'Titre de la news'))
            ->add('subtitle',null,array('label' => 'Sous-titre'))
            ->add('text','ckeditor')
            ->add('main_banner','file',array('label' => 'Image', 'data_class' => null));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title');
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $author = $this->em->getRepository('ESGamingUserBundle:User')->find(27);
        $status = $this->em->getRepository('ESGamingNewBundle:Status')->find(1);
        $type = $this->em->getRepository('ESGamingNewBundle:Type')->find(1);
        $instance->setStatus($status);
        $instance->setType($type);
        $instance->setAuthor($author);

        return $instance;
    }

    /**
     * @param News $news
     */
    public function prePersist($news)
    {
        $this->manageFileUpload($news);
    }

    /**
     * @param News $news
     */
    public function preUpdate($news)
    {
        $this->manageFileUpload($news);
    }

    /**
     * @param News $news
     */
    private function manageFileUpload($news)
    {
        if ($news->getMainBanner() != null) {
            $id_name = uniqid(md5(true));
            $new_filename =  $news->getUploadRootDir().'/'.$id_name.'.jpg';
            rename($news->getMainBanner(), $new_filename);
            $news->setMainBanner( $news->getUploadDir().'/'.$id_name.'.jpg');
        }
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