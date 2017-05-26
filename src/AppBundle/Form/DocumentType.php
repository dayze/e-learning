<?php

namespace AppBundle\Form;

use AppBundle\Entity\CourseCategory;
use AppBundle\Entity\Document;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class DocumentType extends AbstractType
{
    private $em;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->em = $options["em"];
        $builder
            ->add('name')
            ->add('docRelation', CollectionType::class, [
                'entry_type' => DocRelationType::class,
                'entry_options' => ['label' => false, 'em' => $this->em, "supervisor_id" => $options['supervisor_id']],
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'allow_delete' => true,
                'attr' => ['class' => 'section-collection'],
            ])
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary")));
        if($options['isEdit']){
            $builder->add('path', FileType::class, [
                "required" => false
            ]);
        }
        else{
            $builder->add('path', FileType::class, [
               'constraints' => [
                   new NotBlank(["message" => "Vous dezvez séléctionner un document"]),
               ]
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Document::class,
            'em' => null,
            'supervisor_id' => null,
            'isEdit' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_document';
    }


}
