<?php 
namespace App\Form\Type;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionContactInfo;
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

class InstitutionStudentDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('term',null, ['empty_data' => ''])
            ->add('year',null, ['empty_data' => ''])
            ->add('totalStudents',null, ['empty_data' => ''])
            ->add('femaleStudents',null, ['empty_data' => ''])
            ->add('maleStudents',null, ['empty_data' => ''])
            ->add('undergradStudents',null, ['empty_data' => ''])
            ->add('gradStudents',null, ['empty_data' => ''])
            ->add('otherStudents',null, ['empty_data' => ''])
            ->add('fullTimeStudents',null, ['empty_data' => ''])
            ->add('inStateStudents',null, ['empty_data' => ''])
            ->add('outOfStateStudents',null, ['empty_data' => ''])
            ->add('partTimeStudents',null, ['empty_data' => ''])
            ->add('interNationalStudents',null, ['empty_data' => ''])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionStudentDetails::class
        ]);
    }
}