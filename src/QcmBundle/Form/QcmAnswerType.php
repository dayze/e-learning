<?php


namespace QcmBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('response', TextType::class, ['label' => false])
            ->add('isCorrect', CheckboxType::class, [
                'label' => "Est correct ?",
                'required' => false,
                'attr' => ["class" => "checkbox-inline"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QcmBundle\Entity\QcmAnswer'
        ));
    }

    public function getBlockPrefix()
    {
        return 'qcmbundle_qcmanswer';
    }
}