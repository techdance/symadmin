<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\GroupHasEntity;
use App\Entity\User;
use App\Form\UserType;
use App\Model\RoleModel;
use Doctrine\DBAL\Types\DateType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends EasyAdminController
{
   
    public function updateEntity($entity)
    {
        parent::updateEntity($entity);
    }
    

    protected function persistEntity($entity)
    {
        
        $this->em->persist($entity);
        $this->em->flush();

        $groupRepository = $this->getDoctrine()->getRepository(Group::class);
        $groups = $groupRepository->findAll();

        foreach($groups as $group)
        {
            $hasEntity = new GroupHasEntity();
            $hasEntity->setEntities($entity);

            if (in_array($group->getName(), [RoleModel::ROLE_DEVELOPER, RoleModel::ROLE_SUPER_ADMIN])) {
                $hasEntity->setRoles(RoleModel::ACTION_ALL_PERMISSIONS);
            }

            if ($group->getName() == RoleModel::ROLE_ADMIN) {
                $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_ADMIN);
            }

            if ($group->getName() == RoleModel::ROLE_USER) {
                $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_USER);
            }

            $hasEntity->setGroups($group);
            $hasEntity->setName($entity->getName() . '_' . $group->getId());
            
            $this->em->persist($hasEntity);
            $this->em->flush($hasEntity);
        }
    }


    protected function removeEntity($entity)
    {

        $this->em->remove($entity);
        $this->em->flush();
    }
}