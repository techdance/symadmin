<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Form\Type\UserType;
use App\Manager\UserManager;
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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends EasyAdminController
{
    private $passwordEncoder;

    private $userManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserManager $userManager)
    {
        $this->passwordEncoder = $passwordEncoder;

        $this->userManager = $userManager;

    }
    
    public function updateEntity($entity)
    {
       
       
        if ($entity->getPlainPassword()) {
            $encodedPassword = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPlainPassword($entity->getPlainPassword());
            $entity->setPassword($encodedPassword);
            $entity->setDummyPassword($entity->getPlainPassword());
        }

        
        
        parent::updateEntity($entity);


        $this->userManager->curSendPost($entity);
        
        //$response = $this->userManager->updateUserToExternalApi($entity->getUserName());

       

        // if ($response['statusCode'] !== 200) {
        //     $this->addFlash('warning', 'Update user to external api have some issue.');
        // }

        $this->addFlash('success', 'User updated successfully');
    }

    protected function persistEntity($entity)
    {

       
        $userRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
            'name' => RoleModel::ROLE_USER
        ]);
        
        if (!is_null($userRole)) {
            $entity->addGroup($userRole);
        }


        $defaultUserRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
            'name' => RoleModel::ROLE_STUDENT
        ]);

        if (!is_null($defaultUserRole)) {
            $entity->addGroup($defaultUserRole);
        }
       
        if(!$entity->getId() && !$entity->getPlainPassword()) {
            $entity->setPlainPassword(base64_encode(rand(1000000000,9999999999)));
        }

        if ($entity->getPlainPassword()) {
            $encodedPassword = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPlainPassword($entity->getPlainPassword());
            $entity->setPassword($encodedPassword);
            $entity->setDummyPassword($entity->getPlainPassword());
        }

        $this->em->persist($entity);
        $this->em->flush();

        $this->userManager->curSendPost($entity);

        // $response = $this->userManager->updateUserToExternalApi($entity->getUserName());

        // if ($response['statusCode'] !== 200) {
        //     $this->addFlash('warning', 'Update user to external api have some issue.');
        // }

        $this->addFlash('success', 'User created successfully');

        
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

        
         
        foreach ($rowArray as $row) {
            
            if (!$row[5]) {
                continue;
            }

            if ($userManager->findUserByEmail($row[5])) {
               $existsUser[] = $row;
               continue;
            }
            
            $user = $userManager->createUser();

            $row[0] && $user->setPrefix($row[0]);
            $row[1] && $user->setFirstName($row[1]);
            $row[2] && $user->setMiddleName($row[2]);
            $row[3] && $user->setLastName($row[3]);
            $row[4] && $user->setUsername($row[4]);
            $row[5] && $user->setEmail($row[5]);
            $row[5] && $user->setEmailCanonical($row[5]);
            $user->setEnabled(1);
            $row[6] && $user->setInstitutionName($row[6]);
            $row[7] && $user->setPhone($row[7]);
            $row[8] && $user->setSsn($row[8]);
            if ($row[9]) {
                $user->setVetran((strtolower($row[9]) == 'yes' || $row[9] == 1) ? 1 : 0);
            }
            
           
            $row[10] && $user->setEthinicity($row[10]);
            $row[11] && $user->setDateOfBirth(\DateTime::createFromFormat('d/m/Y', $row[11]));
            $row[12] && $user->setGender(ucfirst($row[12]));
            $row[13] && $user->setEmergencyContactPerson($row[13]);
            $row[14] && $user->setEmergencyContactPhone($row[14]);
            $row[15] && $user->setAddress1($row[15]);
            $row[16] && $user->setAddress2($row[16]);
            $row[17] && $user->setCity($row[17]);
            $row[18] && $user->setState($row[18]);
            $row[19] && $user->setZip($row[19]);

            if ($row[20]) {

                $userRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
                    'name' => $row[20]
                ]);

                if (!is_null($userRole)) {
                    $user->addGroup($userRole);
                }
            }
            $row[21] && $user->setPosition($row[21]);

            $user->setPlainPassword(base64_encode(rand(1000000000,9999999999)));

            if (!is_null($defaultUserRole)) {
                $user->addGroup($defaultUserRole);
            }

            $userManager->updateUser($user);
            
            //$this->userManager->curSendPost($user);

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

     /**
     * @Route("/curl/test", name="curl_test", methods={"GET"})
     */
    public function curlTest()
    {
        $this->userManager->updateUserToExternalApi('testuser_1');
    }

    /**
     * @Route("/curl/test2", name="curl_test2", methods={"GET"})
     */
    public function curlTest2()
    {
        $this->userManager->curlTest2();
    }

    /**
     * @Route("/curl/test3", name="curl_test3", methods={"GET"})
     */
    public function curlTest3()
    {
        $this->userManager->moodleApi('testuser_1');
    }


    /**
     * @Route("/curl/post", name="curl_post", methods={"GET"})
     */
    public function curSendPost()
    {
        $username = 'testuser_1';

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByUsername($username);
        $this->userManager->curSendPost($user);
    }


}