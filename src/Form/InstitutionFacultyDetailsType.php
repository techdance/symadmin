<?php 
namespace App\Form\Type;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
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

class InstitutionFacultyDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('term')
            ->add('year')
            ->add('fullTimeFaculty')
            ->add('studentFacultyRatio')
            ->add('facultyHigherDegree')
            ->add('avgUGClassSize')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionFacultyDetails::class
        ]);
    }
}