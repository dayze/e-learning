<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                "label" => "Prénom :",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('lastName', TextType::class, [
                "label" => "Nom :",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("username", TextType::class, [
                "label" => "Pseudo :",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email :",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('plainPassword', PasswordType::class, array(
                "label" => "Mot de passe :",
                "attr" => ["class" => "form-control"],
                'constraints' => array(new NotBlank(array(
                'groups' => array('form_validation_only')
            )))))
            ->add('sections', EntityType::class, array(
                "label" => "Votre section :",
                "attr" => [
                    "class" => "form-control marg-bottom-5"
                ],
                'class' => 'AppBundle\Entity\Section',
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false
            ))
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary btn-block btn-large")));
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
        return 'appbundle_student';
    }


}
