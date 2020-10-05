<?php 
namespace App\Form\Type;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Entity\InstitutionCollegeSchools;
use App\Entity\InstitutionContactInfo;
use App\Entity\InstitutionProfile;
use App\Entity\Documents;
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class DocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('category', TextType::class, [
                'data_class' => null
            ])
            ->add('sub_category', TextType::class, [
                'data_class' => null
            ])
            ->add('file_url', FileType::class, [
                'data_class' => null
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Profile'])
        ;
    }

  

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documents::class
        ]);
    }
}