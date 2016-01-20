<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 06/01/2016
 * Time: 12:17
 */

namespace ESGaming\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', 'password', array(
            'label' => 'Ancien mot de passe'
        ));
        $builder->add('newPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'required' => true,
            'first_options'  => array('label' => 'Nouveau mot de passe'),
            'second_options' => array('label' => 'Repeter le nouveau mot de passe'),
        ));
        $builder->add('Modifier le mot de passe', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ESGaming\UserBundle\Form\Model\ChangePassword',
        ));
    }

    public function getName()
    {
        return 'change_passwd';
    }
}