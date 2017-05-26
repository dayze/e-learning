<?php


namespace QcmBundle\Form;


use AppBundle\Form\DocRelationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmCsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isEvaluated', CheckboxType::class, [
                'label' => "Est noté ?",
                'required' => false,
            ])
            ->add('file', FileType::class,[
                'mapped' => false,
                'label' => 'Fichier CSV'
            ])
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
        "attr" => array("class" => "btn btn-primary")));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QcmBundle\Entity\Qcm',
            'em' => null,
            'supervisor_id' => null
        ));
    }

    public function getBlockPrefix()
    {
        return 'qcmbundle_qcm';
    }
}