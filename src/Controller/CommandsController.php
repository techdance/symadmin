<?php

namespace App\Controller;

use App\Entity\Entitygroup;
use App\Entity\InstitutionProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Manager\UserManager;
use App\Model\RoleModel;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpClient\HttpClient;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Group;
use App\Entity\GroupHasEntity;

class CommandsController extends AbstractController
{
    

    public function __construct()
    {
        
    }

    /**
     * @Route("/initial-setup", name="initial_setup", methods={"GET"})
     */
    public function initializationSetup()
    {   
        $em = $this->getDoctrine()->getManager();

        $rolesArray = [
            'ROLE_SUPER_ADMIN'
        ];

        $roleGroup = new Group();
        $roleGroup->setName($rolesArray[0]);
        $em = $this->getDoctrine()->getManager();
        $em->persist($roleGroup);
        $em->flush();

        $modulesArray = [
            [
                "label" => "Users",
                "module" => 'User'
            ],
            [
                "label" => "Role Permissions",
                "module" => 'RolePermission'
            ],
            [
                "label" => "Institution Profile",
                "module" => 'InstitutionProfile'
            ],
            [
                "label" => "Form Builder",
                "module" => 'Form'
            ]
        ];


        foreach($modulesArray as $module)
        {   
            $entityGroup = new Entitygroup();
            $entityGroup->setLabel($module['label']);
            $entityGroup->setName($module['module']);

            $em->persist($entityGroup);
            $em->flush();

            $groupRepository = $this->getDoctrine()->getRepository(Group::class);
            $groups = $groupRepository->findAll();

            foreach($groups as $group)
            {
                $hasEntity = new GroupHasEntity();
                $hasEntity->setEntities($entityGroup);

                if (in_array($group->getName(), [RoleModel::ROLE_DEVELOPER, RoleModel::ROLE_SUPER_ADMIN])) {
                    $permissions = RoleModel::ACTION_ALL_PERMISSIONS;
                    $permissions[] = 'CAN_SEARCH';
                    $hasEntity->setRoles($permissions);
                }

                if ($group->getName() == RoleModel::ROLE_ADMIN) {
                    $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_ADMIN);
                }

                if ($group->getName() == RoleModel::ROLE_USER) {
                    $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_USER);
                }

                $hasEntity->setGroups($group);
                $hasEntity->setName($entityGroup->getName() . '_' . $group->getId());
                
                $em->persist($hasEntity);
                $em->flush($hasEntity);
            }
        } 

        return new JsonResponse(['inititalSetupStatus' => true]);
    }

    /**
     * @Route("/module-create/{module}/{label}", name="module_create", methods={"GET"})
     */
    public function moduleCreate(Request $request, $module, $label)
    {   
        $em = $this->getDoctrine()->getManager();

        $modulesArray = [
            [
                "label" => $label,
                "module" => $module
            ]
        ];

       

        foreach($modulesArray as $module) {   

            $entityGroup = new Entitygroup();
            $entityGroup->setLabel($module['label']);
            $entityGroup->setName($module['module']);

            $em->persist($entityGroup);
            $em->flush();

            $groupRepository = $this->getDoctrine()->getRepository(Group::class);
            $groups = $groupRepository->findAll();

            foreach($groups as $group)
            {
                $hasEntity = new GroupHasEntity();
                $hasEntity->setEntities($entityGroup);

                if (in_array($group->getName(), [RoleModel::ROLE_DEVELOPER, RoleModel::ROLE_SUPER_ADMIN])) {
                    $permissions = RoleModel::ACTION_ALL_PERMISSIONS;
                    $permissions[] = 'CAN_SEARCH';
                    $hasEntity->setRoles($permissions);
                }

                if ($group->getName() == RoleModel::ROLE_ADMIN) {
                    $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_ADMIN);
                }

                if ($group->getName() == RoleModel::ROLE_USER) {
                    $hasEntity->setRoles(RoleModel::PERMISSION_FOR_ROLE_USER);
                }

                $hasEntity->setGroups($group);
                $hasEntity->setName($entityGroup->getName() . '_' . $group->getId());
                
                $em->persist($hasEntity);
                $em->flush($hasEntity);
            }
        } 

        return new JsonResponse(['status' => 'Module Create Successfully']);
    }

    
}
