<?php


namespace QcmBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('qcmQuestions', CollectionType::class, [
                'entry_type' => QcmQuestionType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QcmBundle\Entity\Qcm'
        ));
    }

    public function getBlockPrefix()
    {
        return 'qcmbundle_qcm';
    }
}