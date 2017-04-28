<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sections', EntityType::class, array(
                'class' => 'AppBundle\Entity\Section',
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false
            ))
            ->add("username")
            ->add('email')
            ->add('plainPassword', PasswordType::class, array('constraints' => array(new NotBlank(array(
                'groups' => array('form_validation_only')
            )))))
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary") ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('form_validation_only')
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
