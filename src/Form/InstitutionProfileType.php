<?php 
namespace App\Form\Type;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionCollegeSchools;
use App\Entity\InstitutionContactInfo;
use App\Entity\InstitutionProfile;
use App\Form\Type\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InstitutionProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('institutionName')
            ->add('campusName')
            ->add('insProfileImage', FileType::class, [
                'data_class' => null
            ])
            ->add('founded')
            ->add('insType')
            ->add('language')
            ->add('president')
            ->add('academicCalendar')
            ->add('otherLanguages')
            ->add('totalEmployees')
            ->add('alumini')
            ->add('overview', TextareaType::class)
            ->add('institutionContact', InstitutionContactInfoType::class)
            ->add('institutionLocation', InstitutionLocationInfoType::class)
            ->add('studentDetails', InstitutionStudentDetailsType::class)
            ->add('facultyDetails', InstitutionFacultyDetailsType::class)
            ->add('academicDetails', InstitutionAcademicDetailsType::class)
            ->add('collegeSchools', CollectionType::class, [
                'entry_type' => InstitutionCollegeSchoolsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('accrediations', CollectionType::class, [
                'entry_type' => InstitutionAccrediationsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('recognitions', CollectionType::class, [
                'entry_type' => InstitutionRecognitioinsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('degrees', CollectionType::class, [
                'entry_type' => InstitutionDegreesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('socialMedias', CollectionType::class, [
                'entry_type' => SocialMediaUrlsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Profile'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionProfile::class
        ]);
    }
}