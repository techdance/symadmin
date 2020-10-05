<?php 
namespace App\Form;

use App\Form\Type\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('prefix')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('institutionName')
            ->add('enabled')
            ->add('password')
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'ROLE_USER' => 'ROLE_USER', 
            //         'ROLE_ADMIN'=> 'ROLE_ADMIN', 
            //         'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'
            //     ]
            // ])
            ->add('groups', EntityType::class, [ 
                                'class'        => 'App\Entity\Group',
                                'choice_label' => 'name',
                                'label'     => 'Role',
                                'expanded'  => false,
                                'multiple'  => true,
                            ])
            ->add('Create', SubmitType::class)
        
        ;
    }
}