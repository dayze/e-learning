<?php

namespace QcmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('qcmAnswers', CollectionType::class, [
                'entry_type' => QcmAnswerType::class,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'allow_delete' => true,
                'prototype_name' => '__children_name__',
                'attr' => ['class' => 'child-collection answer-qcm'],
                'entry_options' => ['label' => false],
                'label' => 'Réponses :',
                'label_attr' => [
                    "class" => "label-answer-qcm"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QcmBundle\Entity\QcmQuestion'
        ));
    }

    public function getBlockPrefix()
    {
        return 'qcmbundle_qcmquestion';
    }


}
