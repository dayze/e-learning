<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->supervisor = $options['supervisor'];
        $builder
            ->add("name")
            ->add('sections', EntityType::class,[
                'class' => 'AppBundle\Entity\Section',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('sec')
                        ->innerJoin('sec.supervisors', 'sup')
                        ->where('sup.id = :sup_id')
                        ->setParameter('sup_id', $this->supervisor->getId());
                },
                'multiple' => true,
            ])
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary") ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
            'supervisor' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_course';
    }


}
