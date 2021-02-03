<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Master\FosGroup;
use App\Entity\InstitutionProfile;
use App\Entity\Group;
use App\Entity\User;
use App\Entity\Master\FosUser;
use App\Form\UserType;
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
use Doctrine\Common\Collections\ArrayCollection;
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
        $this->userDataSave($entity);

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

        $userRole = $this->getDoctrine()->getRepository(FosGroup::class)->findOneBy([
            'name' => RoleModel::ROLE_USER
        ]);

    
            
        $this->em->persist($entity);
        $this->em->flush();
        $this->userDataSave($entity);
        $this->userManager->curSendPost($entity);

        // $response = $this->userManager->updateUserToExternalApi($entity->getUserName());

        // if ($response['statusCode'] !== 200) {
        //     $this->addFlash('warning', 'Update user to external api have some issue.');
        // }

        $this->addFlash('success', 'User created successfully');

        
    }

    public function userDataSave($entity) 
    {
        
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository(InstitutionProfile::class)->find(1); 
        if(!empty($profile)){
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $entity->getId(),'institutionCode' => $profile->getInstitutionName()
        ]);
        
        if(empty($Muser)){
        $Muser = new FosUser();
        }
        
        $Muser->setInstitutionCode($profile->getInstitutionName());
        $Muser->setLocalFosId($entity->getId());
        $Muser->setUsername($entity->getUsername());
        $Muser->setUsernameCanonical($entity->getusernameCanonical());
        $Muser->setEmail($entity->getEmail());
        $Muser->setEmailCanonical($entity->getEmailCanonical());
        $Muser->setEnabled($entity->isEnabled());
        $Muser->setSalt($entity->getSalt());
        $Muser->setPassword($entity->getPassword());
        $Muser->setLastLogin($entity->getLastLogin());
        $Muser->setConfirmationToken($entity->getConfirmationToken());
        $Muser->setPasswordRequestedAt($entity->getPasswordRequestedAt());
        $Muser->setRoles($entity->getRoles());
        $Muser->setFirstName($entity->getFirstName());
        $Muser->setLastName($entity->getLastName());
        $Muser->setPrefix($entity->getPrefix());
        $Muser->setInstitutionName($entity->getInstitutionName());
        $Muser->setPhone($entity->getPhone());
        $Muser->setSsn($entity->getSsn());
        $Muser->setVetran($entity->getVetran());
        $Muser->setDepartment($entity->getDepartment());
        $Muser->setEthinicity($entity->getEthinicity());
        $Muser->setDateOfBirth($entity->getDateOfBirth());
        $Muser->setGender($entity->getGender());
        $Muser->setEmergencyContactPerson($entity->getEmergencyContactPerson());
        $Muser->setEmergencyContactPhone($entity->getEmergencyContactPhone());
        $Muser->setAddress1($entity->getAddress1());
        $Muser->setAddress2($entity->getAddress2());
        $Muser->setCity($entity->getCity());
        $Muser->setState($entity->getState());
        $Muser->setZip($entity->getZip());
        $Muser->setMiddleName($entity->getMiddleName());
        $Muser->setPosition($entity->getPosition());
        $Muser->setDepartment($entity->getDepartment());
        $Muser->setDummyPassword($entity->getDummyPassword());
        foreach($entity->getGroups() as $group_data){    
        $Mgroup_array_collection = $this->getDoctrine()->getRepository(FosGroup::class)->findOneBy([
            'id' => $group_data->getId()]);;
        if(!empty($Mgroup_array_collection)){
        $Muser->addGroup($Mgroup_array_collection); 
        }           
        }
        $em->persist($Muser);
        $em->flush();
        }
        return true;
    }

    /**
     * @Route("/admin/import-users", name="import-users", methods={"POST"})
     */
    public function importUsers(Request $request) 
    {
        $csvFile = $request->files->get('userFile');
        $rowArray = array_map('str_getcsv', file($csvFile->getPathName()));
        array_shift($rowArray);
        $em = $this->getDoctrine()->getManager();
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
            $row[12] && $user->setDepartment(ucfirst($row[13]));
            $row[13] && $user->setEmergencyContactPerson($row[14]);
            $row[14] && $user->setEmergencyContactPhone($row[15]);
            $row[15] && $user->setAddress1($row[16]);
            $row[16] && $user->setAddress2($row[17]);
            $row[17] && $user->setCity($row[18]);
            $row[18] && $user->setState($row[19]);
            $row[19] && $user->setZip($row[20]);
         
            if ($row[20]) {

                $userRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
                    'name' => $row[21]
                ]);

                if (!empty($userRole)) {
                    $user->addGroup($userRole);
                }
            }
            $row[21] && $user->setPosition($row[22]);
            
            $user->setPlainPassword(base64_encode(rand(1000000000,9999999999)));

            if (!is_null($defaultUserRole)) {
                $user->addGroup($defaultUserRole);
            }

            $em->persist($user);
            $em->flush();
            $this->userDataSave($user);
           
            //$userManager->updateUser($user);
            
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

    /**
     * @Route("/deleteMainUser", name="delete_user")
     */
    public function deleteMainUser(Request $request) {

        
        $em = $this->getDoctrine()->getManager();
        $user_request_data = $request->request->get('delete_id');
        $user_Array = explode(',', $user_request_data);

        if(!empty($user_Array)){

        foreach($user_Array as $user_id){
       
        $userManager = $this->get('fos_user.user_manager');
        /* @var $userManager UserManager */
    
        $user = $userManager->findUserBy(array('id'=>$user_id));

        $profile = $em->getRepository(InstitutionProfile::class)->find(1); 
      
        
        if(\is_null($user)) {
        // user not found, generate $notFoundResponse
        return $notFoundResponse;
        }
        
        $em = $this->getDoctrine()->getManager();
        if(!empty($profile)){
        $Muser = $em->getRepository(FosUser::class)->findOneBy([
                'localFosId' => $user->getId(),'institutionCode' => $profile->getInstitutionName()
            ]);
        if(!empty($Muser)){
            $em->remove($Muser);
            $em->flush();
        }
        }

        \assert(!\is_null($user));
        $userManager->deleteUser($user);
       }
       }

        return $this->redirect($this->generateUrl('easyadmin'));
    }


    /**
     * @Route("/getInstName", name="get_institu_name")
     */
    public function getInstName(Request $request): Response
    {
       
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository(InstitutionProfile::class)->find(1); 
    
            return new Response($profile->getInstitutionName());
 

    }

}