<?php 
namespace App\Form;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionContactInfo;
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

class InstitutionContactInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('officeNumber',null, ['empty_data' => ''])
            ->add('mailingName',null, ['empty_data' => ''])
            ->add('faxNumber',null, ['empty_data' => ''])
            ->add('department',null, ['empty_data' => ''])
            ->add('website',null, ['empty_data' => ''])
            ->add('email',null, ['empty_data' => ''])
            ->add('address1',null, ['empty_data' => ''])
            ->add('address2',null, ['empty_data' => ''])
            ->add('city',null, ['empty_data' => ''])
            ->add('state',null, ['empty_data' => ''])
            ->add('postalCode',null, ['empty_data' => ''])
            ->add('new',null, ['empty_data' => ''])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InstitutionContactInfo::class
        ]);
    }
}