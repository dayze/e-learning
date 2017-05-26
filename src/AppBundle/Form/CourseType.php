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
        $this->supervisor_id = $options['supervisor_id'];
        $builder
            ->add("name")
            ->add('sections', EntityType::class, [
                'class' => 'AppBundle\Entity\Section',
                'query_builder' => function (EntityRepository $er) {
                    if (!is_null($this->supervisor_id)) {
                        return $er->createQueryBuilder('sec')
                            ->innerJoin('sec.supervisors', 'sup')
                            ->where('sup.id = :sup_id')
                            ->setParameter('sup_id', $this->supervisor_id);
                    }
                },
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
            'supervisor_id' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_course';
    }


}
