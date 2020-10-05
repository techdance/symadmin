<?php 
namespace App\Form;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionCollegeSchools;
use App\Entity\InstitutionContactInfo;
use App\Entity\InstitutionDegrees;
use App\Entity\InstitutionProfile;
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

class InstitutionDegreesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('degreeName',null, ['empty_data' => ''])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionDegrees::class
        ]);
    }
}