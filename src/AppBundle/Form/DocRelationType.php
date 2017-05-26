<?php


namespace AppBundle\Form;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use AppBundle\Entity\DocRelation;
use AppBundle\Entity\Section;
use AppBundle\Repository\SectionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DocRelationType extends AbstractType
{

    private $em;
    private $supervisor_id;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->em = $options["em"];
        $this->supervisor_id = $options["supervisor_id"];
        $builder
            ->add('available', CheckboxType::class, [
                'label' => "Disponible",
                "required" => false
            ])
            ->add('section', EntityType::class, [
                'attr' => ['class' => 'section-input'],
                'placeholder' => '-- Choisir --',
                'constraints' => new NotBlank(),
                'label' => "Section :",
                'class' => Section::class,
                'query_builder' => function (SectionRepository $section) use ($options) {
                    if(!is_null($options["supervisor_id"])){
                        return $section->createQueryBuilder('sec')
                            ->innerJoin('sec.supervisors', 'sup')
                            ->where('sup.id = :sup_id')
                            ->setParameter('sup_id', $options["supervisor_id"]);
                    }
                    else{
                        return $section->createQueryBuilder('sec');
                    }
                }
            ]);

        $addCourseForm = function (FormInterface $form, Section $section = null) {
            $courses = !is_null($section) ? $section->getCourses() : [];
            $form->add('course', EntityType::class, array(
                'class' => Course::class,
                'placeholder' => '-- Choisir --',
                'choices' => $courses,
                'label' => "Cours :",
                'constraints' => new NotBlank(),
                'attr' => ['class' => 'course-input'],
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addCourseForm) {
                $data = $event->getData();
                $section = !is_null($data) ? $data->getSection() : null;
                $addCourseForm($event->getForm(), $section);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addCourseForm) {
                $data = $event->getData();
                $section_id = array_key_exists('section', $data) ? $data['section'] : null;
                if (!is_null($section_id)) {
                    $section = $this->em->getRepository('AppBundle:Section')->find($section_id);
                } else {
                    $section = null;
                }
                $addCourseForm($event->getForm(), $section);
            }
        );

        $addCourseCategoryForm = function (FormInterface $form, Course $course = null) {
            $courseCategories = !is_null($course) ? $course->getCourseCategories() : [];
            $form->add('courseCategory', EntityType::class, array(
                'class' => CourseCategory::class,
                'placeholder' => '-- Choisir --',
                'attr' => ['class' => 'courseCategory-input'],
                'constraints' => new NotBlank(),
                'label' => "Matière : ",
                'choices' => $courseCategories,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($addCourseCategoryForm) {
                $data = $event->getData();
                $course = null;
                $course = !is_null($data) ? $data->getCourse() : null;

                $addCourseCategoryForm($event->getForm(), $course);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($addCourseCategoryForm) {
                $data = $event->getData();
                $course_id = array_key_exists('course', $data) ? $data['course'] : null;
                if (!is_null($course_id)) {
                    $course = $this->em->getRepository('AppBundle:Course')->find($course_id);
                } else {
                    $course = null;
                }
                $addCourseCategoryForm($event->getForm(), $course);
            }
        );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DocRelation::class,
            'em' => null,
            'supervisor_id' => null
        ));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_docrelation';
    }
}