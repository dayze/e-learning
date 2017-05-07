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

class DocumentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->supervisor = $options['supervisor'];
        $builder
            ->add('path', FileType::class)
            ->add('available', CheckboxType::class, [
                'label' => 'Disponible'
            ])
            ->add('name')
            ->add('sections', CollectionType::class, [
                'entry_type' => SectionDocType::class,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'allow_delete' => true,
                'attr' => ['class' => 'section-collection'],
                'label' => false,
                'mapped' => false
            ])
            /*->add('sections', EntityType::class, array(
                'class' => 'AppBundle\Entity\Section',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sec')
                        ->innerJoin('sec.supervisors', 'sup')
                        ->where('sup.id = :sup_id')
                        ->setParameter('sup_id', $this->supervisor->getId());
                },
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false
            ))*/
            /*->add('courseCategory', EntityType::class, array(
                'class' => 'AppBundle\Entity\CourseCategory',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('cc')
                        ->innerJoin('cc.course', 'c')
                        ->addSelect('c')
                        ->innerJoin('c.supervisor', 'sup')
                        ->where('sup.id = :sup_id')
                        ->setParameter('sup_id', $this->supervisor->getId());
                },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ))*/
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary")));;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Document::class,
            'supervisor' => null,
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
