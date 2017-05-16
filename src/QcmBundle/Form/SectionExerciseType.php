<?php


namespace QcmBundle\Form;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use AppBundle\Entity\Section;
use QcmBundle\Entity\Qcm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('section', EntityType::class, [
                'attr' => ['class' => 'section-input'],
                'class' => Section::class,
                'mapped' => false,
                'required' => false,
                'label' => 'Section'
            ])
            ->add('course', EntityType::class, [
                'attr' => ['class' => 'course-input'],
                'mapped' => false,
                'label' => 'Cours',
                'class' => Course::class
            ])
            ->add('courseCategory', EntityType::class, [
                'attr' => ['class' => 'courseCategory-input'],
                'mapped' => false,
                'label' => 'Matière',
                'class' => CourseCategory::class
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Qcm::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'qcmbundle_qcm';
    }
}