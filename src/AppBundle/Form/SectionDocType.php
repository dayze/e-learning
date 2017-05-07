<?php


namespace AppBundle\Form;


use AppBundle\Entity\CourseCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class SectionDocType extends DocumentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sections', EntityType::class, [
                'class' => 'AppBundle\Entity\Section',
                'label' => 'Section',
                /* 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('sec')
                         ->innerJoin('sec.supervisors', 'sup')
                         ->where('sup.id = :sup_id')
                         ->setParameter('sup_id', $this->supervisor->getId());
                 },*/
                'mapped' => false,
                'attr' => ['class' => 'section-input']
            ])
            ->add('course', EntityType::class, [
                'empty_data' => '-- Choisir --',
                'class' => 'AppBundle\Entity\Course',
                'attr' => ['class' => 'course-input'],
                'mapped' => false
            ])
            ->add('courseCategory', EntityType::class, array(
                    'empty_data' => '-- Choisir --',
                    'class' => 'AppBundle\Entity\CourseCategory',
                    'attr' => ['class' => 'courseCategory-input'],
                    'mapped' => false)
            );
    }
}