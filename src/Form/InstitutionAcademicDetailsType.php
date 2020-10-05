<?php 
namespace App\Form;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionAcademicDetails;
use App\Entity\InstitutionContactInfo;
use App\Entity\InstitutionFacultyDetails;
use App\Entity\InstitutionProfile;
use App\Entity\InstitutionStudentDetails;
use App\Form\Type\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InstitutionAcademicDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('term',null, ['empty_data' => ''])
            ->add('year',null, ['empty_data' => ''])
            ->add('academicYear',null, ['empty_data' => ''])
            ->add('associateDegrees',null, ['empty_data' => ''])
            ->add('bachelorsDegrees',null, ['empty_data' => ''])
            ->add('masterDegrees',null, ['empty_data' => ''])
            ->add('doctorateDegrees',null, ['empty_data' => ''])
            ->add('underGraduate',null, ['empty_data' => ''])
            ->add('graduate',null, ['empty_data' => ''])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionAcademicDetails::class
        ]);
    }
}