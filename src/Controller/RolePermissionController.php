<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\RoleModel;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RolePermissionController extends EasyAdminController
{
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    public function updateEntity($entity)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if (in_array($entity->getName(), [RoleModel::ROLE_SUPER_ADMIN, RoleModel::ROLE_DEVELOPER])) {
         
            return $this->redirectToRoute('easyadmin', [
                'action' => 'edit',
                'entity' => $request->query->get('entity'),
                'menuIndex' => $request->query->get('menuIndex'),
                'submenuIndex' => $request->query->get('submenuIndex'),
                'id' => $entity->getId()
            ]);
        }
        
        foreach ($entity->getEntities() as $hasGroup) {
            $hasGroup->setName($hasGroup->getEntities()->getName() . '_' . $entity->getName());
            $hasGroup->setGroups($entity);
            $this->em->persist( $hasGroup);
        }

        parent::updateEntity($entity);
    }

    protected function persistEntity($entity)
    {
        foreach ($entity->getEntities() as $hasGroup) {
            $hasGroup->setName($hasGroup->getEntities()->getName() . '_' . $entity->getName());
            $hasGroup->setGroups($entity);
            $this->em->persist( $hasGroup);
        }
        
        $this->em->persist($entity);
        $this->em->flush();
    }

    protected function removeEntity($entity)
    {
      
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if (in_array($entity->getName(), [RoleModel::ROLE_SUPER_ADMIN, RoleModel::ROLE_DEVELOPER])) {
         
            return $this->redirectToRoute('easyadmin', [
                'action' => 'edit',
                'entity' => $request->query->get('entity'),
                'menuIndex' => $request->query->get('menuIndex'),
                'submenuIndex' => $request->query->get('submenuIndex'),
                'id' => $entity->getId()
            ]);
        }

        $this->em->remove($entity);
        $this->em->flush();
    }
    
}