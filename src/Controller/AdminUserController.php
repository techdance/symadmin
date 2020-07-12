<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Form\Type\UserType;
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
use Symfony\Component\Security\Core\Role\Role;

class AdminUserController extends EasyAdminController
{
   
    public function updateEntity($entity)
    {
        parent::updateEntity($entity);
    }

    protected function persistEntity($entity)
    {
        $defaultUserRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
            'name' => RoleModel::ROLE_USER
        ]);
        
        if (!is_null($defaultUserRole)) {
            $entity->addGroup($defaultUserRole);
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @Route("/admin/import-users", name="import-users", methods={"POST"})
     */
    public function importUsers(Request $request) 
    {
        $csvFile = $request->files->get('userFile');
        $rowArray = array_map('str_getcsv', file($csvFile->getPathName()));
        array_shift($rowArray);

        $rowArray = count($rowArray) == 1 ?  $rowArray : $rowArray;
        $userManager = $this->get('fos_user.user_manager');


        $defaultUserRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
            'name' => RoleModel::ROLE_USER
        ]);

        $existsUser = [];
        foreach ($rowArray as $key => $row) {
            
            // $row[3] = 'test1@test.com';

            if ($userManager->findUserByEmail($row[3])) {
               $existsUser[] = $row;
               continue;
            }
            
            $user = $userManager->createUser();

            $user->setPrefix($row[0]);
            $user->setFirstName($row[1]);
            $user->setLastName($row[2]);
            $user->setUsername($row[3]);
            $user->setEmail($row[3]);
            $user->setEmailCanonical($row[3]);
            $user->setEnabled(1);
            $user->setInstitutionName($row[4]);
            $user->setPlainPassword(base64_encode(rand(1000000000,9999999999)));

            if (!is_null($defaultUserRole)) {
                $user->addGroup($defaultUserRole);
            }

            $userManager->updateUser($user);
        }

        return $this->redirectToRoute('easyadmin', $request->query->all());
    }

    /**
     * @Route("/migration/migrate-form-image", name="migrate_form_image", methods={"GET"})
     */
    public function migrateFormImage()
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = "ALTER TABLE form ADD form_image VARCHAR(255) NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $this->redirectToRoute('easyadmin');
    }

}