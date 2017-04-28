<?php

namespace QcmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*        $builder
                    ->add('qcmAnswers', EntityType::class, [
                        'class' => 'QcmBundle\Entity\QcmAnswer',
                        'choice_label' => 'response',
                        'expanded' => true
                    ]);*/
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
           $form = $event->getForm();
           $form->add('question');
        });
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
