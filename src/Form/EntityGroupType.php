<?php 
namespace App\Form\Type;

use App\Entity\Entitygroup;
use App\Entity\GroupHasEntity;
use App\Form\Type\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('name', HiddenType::class, [
                 'attr' => array(
                    'readonly' => true,
                ),
            ])
        
            ->add('entities', EntityType::class,
                array(
                    'class' => Entitygroup::class,
                    'label' => '',
                )
            )
         
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'Previlleges',
                'choices'  => array(
                    'CAN_SHOW' => 'CAN_SHOW',
                    'CAN_EDIT' => 'CAN_EDIT',
                    'CAN_DELETE' => 'CAN_DELETE',
                    'CAN_NEW' => 'CAN_NEW',
                    'CAN_IMPORT' => 'CAN_IMPORT',
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupHasEntity::class
        ]);
    }
}