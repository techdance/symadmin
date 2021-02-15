<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Entity\Group;
use App\Entity\InstitutionProfile;
use App\Entity\Master\FosUser;
use App\Entity\Master\MasterLanguage;
use App\Entity\Master\CommunicationPreferences;
use App\Entity\Master\CollaboratedProfileAreaofInterest;
use App\Entity\Master\CollaboratedProjectInvitetracking;
use App\Entity\Master\Collaborateduserprofessionalbio;
use App\Entity\Master\Collaboratedusercredential;
use App\Entity\Master\CollaboratedLanguagePreferences;
use App\Entity\Master\CollaboratedLabScreenProjectPartners;
use App\Entity\Master\MasterInstitutionLocationInfo;
use App\Entity\Master\CollaboratedUserProfileimage;
use App\Entity\Master\FosGroup;
use App\Entity\InstitutionLocationInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Manager\UserManager;
use App\Model\RoleModel;
use Symfony\Component\Security\Csrf\CsrfToken;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpClient\HttpClient;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;


class UserController extends AbstractController
{
    /**
     * @var integer HTTP status code - 200 (OK) by default
     */
    protected $statusCode = 200;

    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Gets the value of statusCode.
     *
     * @return integer
     */
    /**
     * @Route("/user", name="user", schemes={"https"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
     * @Route("/registerUser", name="api_register", methods={"POST"})
     */
    public function registerUser(UserPasswordEncoderInterface $passwordEncoder, Request $request, MailerInterface $mailer)
    {
        $user = new User();
        $prefix                  = $request->request->get("prefix");
        $firstName               = $request->request->get("firstName");
        $lastName                 = $request->request->get("lastName");
        $username                 = $request->request->get("username");
        $institutionEmail        = $request->request->get("institutionEmail");
        $institutionName         = $request->request->get("institutionName");
        $password                 = $request->request->get("password");

        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Password should be at least 8 characters.";
        }
        if (!$errors) {
            // $data = json_decode($request->getContent(), true);
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($institutionEmail);
            $user->setPassword($encodedPassword);
            $user->setUsername($username);
            $user->setDummyPassword($password);
            //$user->setPassword($encodedPassword);
            $user->setPrefix($prefix);
            $user->setFirstName($firstName);
            $user->setMiddleName('');
            $user->setLastName($lastName);
            $user->setInstitutionName($institutionName);
            $user->setEnabled(true);

            $defaultUserRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
                'name' => RoleModel::ROLE_USER
            ]);

            if (!is_null($defaultUserRole)) {
                $user->addGroup($defaultUserRole);
            }

            $em = $this->getDoctrine()->getManager();
            try {

                $em->persist($user);
                $em->flush();
                $name = trim($prefix) . '.' . $firstName . ' ' . $lastName;
                $content = '<h1>Welcome ' . $name . '</h1><p>You signed up with the following email:</p>';
                $content .= '<p><code>' . $institutionEmail . '</code></p>';
                $email = (new Email())
                    ->from('toweredtest@gmail.com')
                    ->to($institutionEmail)
                    ->subject('Thanks for signing up!')
                    ->html($content);
		        $mailer->send($email);

                $this->userManager->curSendPost($user);

                return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUserName()));
                
            } catch (UniqueConstraintViolationException $e) {
                $errors[] = "The email provided already has an account!";
            } catch (\Exception $e) {
                
                $errors[] = "Unable to save new user at this time.";
                $errors[] = $e->getMessage();
            }
        }
        return $this->json([
            'errors' => $errors
        ], 400);
    }


    public function userDataSave($entity) 
    {
        
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository(InstitutionProfile::class)->findOneByInstitutionName($entity->getInstitutionName());
                  
        if(!empty($profile)){
        $institution_location = $em->getRepository(InstitutionLocationInfo::class)->findOneById($profile->getInstitutionLocation());

        $MasterInstitutionLocationInfo = $em->getRepository(MasterInstitutionLocationInfo::class)->findOneBy(['institutecode' => $profile->getInstitutionName()
        ]);

        if(empty($MasterInstitutionLocationInfo)){
            $MasterInstitutionLocationInfo = new MasterInstitutionLocationInfo();
        }              
        
        $MasterInstitutionLocationInfo->setInstitutecode($entity->getInstitutionName());
        $MasterInstitutionLocationInfo->setInstitutename($profile->getInstitutionName());
        $MasterInstitutionLocationInfo->setInstitutecity($institution_location->getCity());
        $MasterInstitutionLocationInfo->setInstitutecountry($institution_location->getCountry());
        $MasterInstitutionLocationInfo->setInstitutedepartment($entity->getDepartment());
        $MasterInstitutionLocationInfo->setInstitutestate($institution_location->getState());
        $MasterInstitutionLocationInfo->setInstitutetimezone($institution_location->getTimezone());
        $MasterInstitutionLocationInfo->setFounded($profile->getFounded());
 
        $em->persist($MasterInstitutionLocationInfo);
        $em->flush();
        }
        return true;
    }

    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $token = bin2hex(random_bytes(32));       
          
        $logintime = new DateTime();
        $username         = trim($request->request->get("institutionEmail"));
        $password         = ($request->request->get("password"));
        if(empty($username)){
            $username         = trim($request->query->get("institutionEmail"));
            $password         = trim($request->query->get("password")); 
        }

        $user =  $this->getDoctrine()->getRepository(User::class)->findOneByEmail($username);                           
  
        if (!$user) {
            //throw $this->createNotFoundException();
            return $this->json([
                'token' => '',
                'message'=>'Invalid User name',
                'status' => false
            ]);
            
        }
        $isValid = $passwordEncoder->isPasswordValid($user, $password);
       
        if (!$isValid) {
            return $this->json([
                'token' => '',
                'message'=>'Invalid username or password',
                'status' => false
            ]);
        }else{
            $user->setApiToken($token);
            $user->setLastLogin($logintime);
            $em->persist($user);
            $em->flush();
        }
  
        $result = $this->serializeUsers($user);

        // 'user' => base64_encode(rand(1000000000,9999999999).$request->request->get("institutionEmail")),
        // 	   'status' => true
        return $this->json([
            'token' => $token,
            'message'=>'Success',
            'status' => true
        ]);
    }


    // /**
    //  * @Route("/getUserDetails", name="api_getUserDetails", methods={"GET"})
    //  */
    // public function getUserDetails(Request $request)
    // {
    //     $username  = substr(base64_decode($request->query->get("user")), 10);
    //     $user = $this->getDoctrine()->getRepository(User::class)->findOneByUsername($username);
    //     if ($user) {
    //         $result = $this->serializeUsers($user);

    //         return $this->json([
    //             'user' => $result
    //         ]);
    //     }
    //     return $this->respondWithSuccess(sprintf('User %s is not available', $username));
    // }

    /**
     * @Route("/api/thoughtSave", name="api_thought_Save", methods={"POST"})
     */
    public function thoughtSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $thought  = $request->query->get("thought");
        $onlinestatus  = $request->query->get("onlinestatus");
        if(empty($token)){
            $token  = $request->request->get("token");
            $thought  = $request->request->get("thought");
            $onlinestatus  = $request->request->get("onlinestatus");
        }
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);

        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);

        if ($Muser) {
            $Muser->setThoughts($thought);
            $Muser->setOnlineStatus($onlinestatus);
            $em->persist($Muser);
            $em->flush();

            return $this->json([
                'message'=>'Thoughts saved successfully',
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'Unable to save information',
                'status' => false
            ]);
        
        }
       
    }


    /**
     * @Route("/api/communicationPreferencesSave", name="api_communication_PreferencesSave_Save", methods={"POST"})
     */
    public function communicationPreferencesSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $primaryLanguageId  = $request->query->get("primaryLanguageId");
        $primaryLanguageName  = $request->query->get("primaryLanguageName");
        $secondaryLanguageId  = $request->query->get("secondaryLanguageId");
        $secondaryLanguageName  = $request->query->get("secondaryLanguageName");
        $tertiaryLanguageId  = $request->query->get("tertiaryLanguageId");
        $tertiaryLanguageName  = $request->query->get("tertiaryLanguageName");
        $emailAddress  = $request->query->get("emailAddress");
        $phoneNumber  = $request->query->get("phoneNumber");
        $website  = $request->query->get("website");
        $mobileNumber  = $request->query->get("mobileNumber");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $primaryLanguageId  = $request->request->get("primaryLanguageId");
            $primaryLanguageName  = $request->request->get("primaryLanguageName");
            $secondaryLanguageId  = $request->request->get("secondaryLanguageId");
            $secondaryLanguageName  = $request->request->get("secondaryLanguageName");
            $tertiaryLanguageId  = $request->request->get("tertiaryLanguageId");
            $tertiaryLanguageName  = $request->request->get("tertiaryLanguageName");
            $emailAddress  = $request->request->get("emailAddress");
            $phoneNumber  = $request->request->get("phoneNumber");
            $website  = $request->request->get("website");
            $mobileNumber  = $request->request->get("mobileNumber");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        
        $CommunicationPreferences = $this->getDoctrine()->getRepository(CommunicationPreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if(empty($CommunicationPreferences)){
            $CommunicationPreferences = new CommunicationPreferences();
        } 
            $CommunicationPreferences->setUserId($Muser->getId());
            $CommunicationPreferences->setCreateDate($createDate);
            $CommunicationPreferences->setModifiedDate($modifiedDate);
            $CommunicationPreferences->setPrimaryLanguageId($primaryLanguageId);
            $CommunicationPreferences->setPrimaryLanguageName($primaryLanguageName);
            $CommunicationPreferences->setSecondaryLanguageId($secondaryLanguageId);
            $CommunicationPreferences->setSecondaryLanguageName($secondaryLanguageName);
            $CommunicationPreferences->setTertiaryLanguageId($tertiaryLanguageId);
            $CommunicationPreferences->setTertiaryLanguageName($tertiaryLanguageName);
            $CommunicationPreferences->setEmailAddress($emailAddress);
            $CommunicationPreferences->setPhoneNumber($phoneNumber);
            $CommunicationPreferences->setWebsite($website);
            $CommunicationPreferences->setMobileNumber($mobileNumber);
            $em->persist($CommunicationPreferences);
            $em->flush();

            return $this->json([
                'message'=>'Communication preferences saved successfully',
                'status' => true
            ]);            

    }



    /**
     * @Route("/api/collaboratedProjectInvitetrackingSave", name="api_collaborated_ProjectInvitetracking_Save", methods={"POST"})
     */
    public function collaboratedProjectInvitetrackingSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $interestId  = $request->query->get("interestId");
        $projectPartnerId  = $request->query->get("projectPartnerId");
        $inviteFrom  = $request->query->get("inviteFrom");
        $inviteTo  = $request->query->get("inviteTo");
        $invitationStatus  = $request->query->get("invitationStatus");
        $isRead  = $request->query->get("isRead");
        $isRemoved  = $request->query->get("isRemoved");
        $messageTitle  = $request->query->get("messageTitle");
        $messageContent  = $request->query->get("messageContent");
        $emailContent  = $request->query->get("emailContent");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $interestId  = $request->request->get("interestId");
            $projectPartnerId  = $request->request->get("projectPartnerId");
            $inviteFrom  = $request->request->get("inviteFrom");
            $inviteTo  = $request->request->get("inviteTo");
            $invitationStatus  = $request->request->get("invitationStatus");
            $isRead  = $request->request->get("isRead");
            $isRemoved  = $request->request->get("isRemoved");
            $messageTitle  = $request->request->get("messageTitle");
            $messageContent  = $request->request->get("messageContent");
            $emailContent  = $request->request->get("emailContent");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneById($interestId);
        if(empty($CollaboratedProfileAreaofInterest)){
            return $this->json([
                'message'=>'Unable to find user collaborated profile area of interest details',
                'status' => false
            ]);        
        }
        
        $CollaboratedProjectInvitetracking = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findOneBy([
            'interestId' => $interestId
        ]);

        if(empty($CollaboratedProjectInvitetracking)){
            $CollaboratedProjectInvitetracking = new CollaboratedProjectInvitetracking();
        } 
            $em->beginTransaction();
                
            $CollaboratedProjectInvitetracking->setCreateDate($createDate);
            $CollaboratedProjectInvitetracking->setModifiedDate($modifiedDate);
            $CollaboratedProjectInvitetracking->setInterestId($CollaboratedProfileAreaofInterest);
            $CollaboratedProjectInvitetracking->setInviteFrom($inviteFrom);
            $CollaboratedProjectInvitetracking->setInviteTo($inviteTo);
            $CollaboratedProjectInvitetracking->setInvitationStatus($invitationStatus);
            $CollaboratedProjectInvitetracking->setIsRead($isRead);
            $CollaboratedProjectInvitetracking->setIsRemoved($isRemoved);
            $CollaboratedProjectInvitetracking->setMessageTitle($messageTitle);
            $CollaboratedProjectInvitetracking->setMessageContent($messageContent);
            $CollaboratedProjectInvitetracking->setEmailContent($emailContent);
            $em->persist($CollaboratedProjectInvitetracking);
            $em->flush();
         

            $CollaboratedLabScreenProjectPartners = $this->getDoctrine()->getRepository(CollaboratedLabScreenProjectPartners::class)->findOneBy([
                'interestId' => $interestId
            ]);
    
            if(empty($CollaboratedLabScreenProjectPartners)){
                $CollaboratedLabScreenProjectPartners = new CollaboratedLabScreenProjectPartners();
            }
            $CollaboratedLabScreenProjectPartners->setCreateDate($createDate);
            $CollaboratedLabScreenProjectPartners->setModifiedDate($modifiedDate);
            $CollaboratedLabScreenProjectPartners->setInterestId($CollaboratedProfileAreaofInterest);
            $CollaboratedLabScreenProjectPartners->setProjectPartnerId($projectPartnerId);
            $CollaboratedLabScreenProjectPartners->setIsActive(1);
            $em->persist($CollaboratedLabScreenProjectPartners);
            $em->flush();

            $em->commit();

            return $this->json([
                'message'=>'Collaborated project invitetracking saved successfully',
                'status' => true
            ]);            

    }

    /**
     * @Route("/api/getCommunicationPreferences", name="api_get_communication_Preferences", methods={"GET"})
     */
    public function getCommunicationPreferences(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $CommunicationPreferences = $this->getDoctrine()->getRepository(CommunicationPreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if ($CommunicationPreferences) {           
            return $this->json([
                'userId'=>$CommunicationPreferences->getUserId(),
                'createDate'=>$CommunicationPreferences->getCreateDate(),
                'modifiedDate'=>$CommunicationPreferences->getModifiedDate(),
                'language'=> ['primary'=>['LanguageId'=>$CommunicationPreferences->getPrimaryLanguageId(),
                              'LanguageName'=>$CommunicationPreferences->getPrimaryLanguageName()],
                             'secondary'=>['LanguageId'=>$CommunicationPreferences->getSecondaryLanguageId(),
                              'LanguageName'=>$CommunicationPreferences->getSecondaryLanguageName()],
                              'tertiary'=>['LanguageId'=>$CommunicationPreferences->getTertiaryLanguageId(),
                'LanguageName'=>$CommunicationPreferences->getTertiaryLanguageName()]],
                'emailAddress'=>$CommunicationPreferences->getEmailAddress(),
                'phoneNumber'=>['landphone'=>$CommunicationPreferences->getPhoneNumber(),
                                'mobileNumber'=>$CommunicationPreferences->getMobileNumber()],
                'website'=>parse_url($CommunicationPreferences->getWebsite()),                
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }


    /**
     * @Route("/api/collaboratedUsercredential", name="api_collaborated_Usercredential_Save", methods={"POST"})
     */
    public function collaboratedUsercredential(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $membership1  = $request->query->get("membership1");
        $membership2  = $request->query->get("membership2");
        $membership3  = $request->query->get("membership3");
        $educationallevel  = $request->query->get("educationallevel");
        $certificate1  = $request->query->get("certificate1");
        $certificate2  = $request->query->get("certificate2");
        $certificate3  = $request->query->get("certificate3");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $membership1  = $request->request->get("membership1");
            $membership2  = $request->request->get("membership2");
            $membership3  = $request->request->get("membership3");
            $educationallevel  = $request->request->get("educationallevel");
            $certificate1  = $request->request->get("certificate1");
            $certificate2  = $request->request->get("certificate2");
            $certificate3  = $request->request->get("certificate3");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
      
        $Collaboratedusercredential = $this->getDoctrine()->getRepository(Collaboratedusercredential::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if(empty($Collaboratedusercredential)){
            $Collaboratedusercredential = new Collaboratedusercredential();
        } 
            $Collaboratedusercredential->setUserId($Muser->getId());
            $Collaboratedusercredential->setCreateDate($createDate);
            $Collaboratedusercredential->setModifiedDate($modifiedDate);
            $Collaboratedusercredential->setMembership1($membership1);
            $Collaboratedusercredential->setMembership2($membership2);
            $Collaboratedusercredential->setMembership3($membership3);
            $Collaboratedusercredential->setEducationallevel($educationallevel);
            $Collaboratedusercredential->setCertificate1($certificate1);
            $Collaboratedusercredential->setCertificate2($certificate2);
            $Collaboratedusercredential->setCertificate3($certificate3);
            $em->persist($Collaboratedusercredential);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated user credential saved successfully',
                'status' => true
            ]);            

    }

    /**
     * @Route("/api/getMessageData", name="api_get_message_data", methods={"GET"})
     */
    public function getMessageData(Request $request)
    {

        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }

        $CollaboratedProjectInvitetracking_received = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findBy(['inviteTo' => $Muser->getId(),'isRead'=>1],['createDate'=>'DESC']); 
     
        $message_received = [];
        if (!empty($CollaboratedProjectInvitetracking_received)) {            
                 
            foreach($CollaboratedProjectInvitetracking_received as $Invitetracking_data){

                $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
                'id' => $Invitetracking_data->getInviteFrom() ]);
                $institution_code = $Muser->getInstitutionCode();
                $MasterInstitutionLocationInfo = $this->getDoctrine()->getRepository(MasterInstitutionLocationInfo::class)->findOneBy(['institutecode' => $institution_code
                ]);

                $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
                    'id' => $Invitetracking_data->getInterestId()
                ]);               
                
                $message_received[] = [
                'image'=>$this->getUserImage($Invitetracking_data->getInviteFrom()),
                'institutionName' => $MasterInstitutionLocationInfo->getInstitutename(),
                'full_name'=>$Muser->getFirstName(),
                'projectType'=>$CollaboratedProfileAreaofInterest->getProjectType(),
                'description'=>$CollaboratedProfileAreaofInterest->getDescription(),
                'discipline1'=>$CollaboratedProfileAreaofInterest->getDisciplineA(),
                'language'=>$CollaboratedProfileAreaofInterest->getLanguage(),
                'location1'=>$CollaboratedProfileAreaofInterest->getLocationA(),
                'messageTitle'=>$Invitetracking_data->getMessageTitle(),
                'messageContent'=>$Invitetracking_data->getMessageContent(),
                'invite_received'=>$Invitetracking_data->getCreateDate()
                 ];
            }
            
        }

        $CollaboratedProjectInvitetracking_send = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findBy(['inviteFrom' => $Muser->getId(),'isRead'=>1],['createDate'=>'DESC']);   
        
        $message_send = [];
        if ($CollaboratedProjectInvitetracking_send) {          
        foreach($CollaboratedProjectInvitetracking_send as $Invitetracking_send_data){
            $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'id' => $Invitetracking_data->getInviteTo() ]);
            $institution_code = $Muser->getInstitutionCode();
            $MasterInstitutionLocationInfo = $this->getDoctrine()->getRepository(MasterInstitutionLocationInfo::class)->findOneBy(['institutecode' => $institution_code
            ]);

            $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
                'id' => $Invitetracking_data->getInterestId()
            ]);  

            $message_send[] = [
            'image'=>$this->getUserImage($Invitetracking_send_data->getInviteTo()),
            'institutionName' => $MasterInstitutionLocationInfo->getInstitutename(),
            'full_name'=>$Muser->getFirstName(),
            'projectType'=>$CollaboratedProfileAreaofInterest->getProjectType(),
            'description'=>$CollaboratedProfileAreaofInterest->getDescription(),
            'discipline1'=>$CollaboratedProfileAreaofInterest->getDisciplineA(),
            'language'=>$CollaboratedProfileAreaofInterest->getLanguage(),
            'location1'=>$CollaboratedProfileAreaofInterest->getLocationA(),
            'messageTitle'=>$Invitetracking_send_data->getMessageTitle(),
            'messageContent'=>$Invitetracking_send_data->getMessageContent(),
            'invite_send'=>$Invitetracking_data->getCreateDate()
                ];
        }
        } 

        if (!empty($message_received)||!empty($message_send)) {
            return $this->json([
                'message_received'=>['data'=>$message_received,'count'=>count($message_received)],
                'message_send'=>['data'=>$message_send,'count'=>count($message_send)],
                'status' => true
            ]);

        }else{
            return $this->json([
                'message'=>'No data not found',
                'status' => false
            ]);
        }


    }

    /**
     * @Route("/api/getNotificationsData", name="api_get_notification_data", methods={"GET"})
     */
    public function getNotificationsData(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }


        // $CollaboratedProjectInvitetracking_received = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findBy(['inviteTo' => $Muser->getId(),'isRead'=>1],['createDate'=>'DESC']); 
 
        $CollaboratedProjectInvitetracking_received = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findBy(['inviteTo' => $Muser->getId(),'isRemoved'=>4],['createDate'=>'DESC']);    
       
            
            $message_received = [];
            if ($CollaboratedProjectInvitetracking_received) {          
            foreach($CollaboratedProjectInvitetracking_received as $Invitetracking_data){
                $message_received[] = [
                'image'=>$this->getUserImage($Invitetracking_data->getInviteFrom()),
                'messageTitle'=>$Invitetracking_data->getMessageTitle(),
                'messageContent'=>$Invitetracking_data->getMessageContent()
                 ];
            }
            }

        $CollaboratedProjectInvitetracking_send = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findBy(['inviteFrom' => $Muser->getId(),'isRemoved'=>0],['createDate'=>'DESC']);    
    
        
        $message_send = [];
        if ($CollaboratedProjectInvitetracking_send) {          
        foreach($CollaboratedProjectInvitetracking_send as $Invitetracking_send_data){
            $message_send[] = [
            'image'=>$this->getUserImage($Invitetracking_send_data->getInviteTo()),
            'messageTitle'=>$Invitetracking_send_data->getMessageTitle(),
            'messageContent'=>$Invitetracking_send_data->getMessageContent()
                ];
        }
        }    

        if (!empty($message_received)||!empty($message_send)) { 
            return $this->json([
                'message_received'=>['data'=>$message_received,'count'=>count($message_received)],
                'message_send'=>['data'=>$message_send,'count'=>count($message_send)],
                'message_count'=>count($message_received),
                'status' => true
            ]);

        }else{
            return $this->json([
                'message'=>'No data not found',
                'status' => false
            ]);
        }

    }

    function getUserImage($user_id)
    {
        $CollaboratedUserProfileimage = $this->getDoctrine()->getRepository(CollaboratedUserProfileimage::class)->findOneBy([
            'userId' => $user_id
        ]);

        if ($CollaboratedUserProfileimage) { 
         return stream_get_contents($CollaboratedUserProfileimage->getBlobData());
        }else{
         return '';  
        }
    }


    /**
     * @Route("/api/getLoginData", name="api_get_login_data", methods={"GET"})
     */
    public function getLoginData(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }else{
            return $this->json([
                'user_image'=>$this->getUserImage($Muser->getId()),
                'user_name'=>$Muser->getFirstName(),
                'status' => true
            ]);
        }
    }
    

    /**
     * @Route("/api/updateProjectInvites", name="update_Project_Invites", methods={"POST"})
     */
    public function updateProjectInvites(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $status  = $request->query->get("status");
        $inviteId  = $request->query->get("inviteId");

        if(empty($token)){
            $token  = $request->request->get("token");
            $status  = $request->request->get("status");
            $inviteId  = $request->request->get("inviteId");
        }

        
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        if(empty($inviteId)){
            return $this->json([
                'message'=>'Invite tracking id not given',
                'status' => false
            ]);        
        }
      
        $CollaboratedProjectInvitetracking = $this->getDoctrine()->getRepository(CollaboratedProjectInvitetracking::class)->findOneById($inviteId);
      

        if(!empty($CollaboratedProjectInvitetracking)){
            if($status == 1){
            $CollaboratedProjectInvitetracking->setInvitationStatus("Declined");
            $CollaboratedProjectInvitetracking->setIsRemoved(1);
            $em->persist($CollaboratedProjectInvitetracking);
            $em->flush();
            return $this->json([
                'message'=>'Declined successfully',
                'status' => true
            ]);
            }elseif($status == 0){
            $CollaboratedProjectInvitetracking->setInvitationStatus("Accepted");
            $CollaboratedProjectInvitetracking->setIsRemoved(0);
            $em->persist($CollaboratedProjectInvitetracking);
            $em->flush();
            return $this->json([
                'message'=>'Accepted successfully',
                'status' => true
            ]);
            }else{
                return $this->json([
                    'message'=>'Status not accepted',
                    'status' => false
                ]); 
            }           
        }else{
            return $this->json([
                'message'=>'Unable to find invite tracking details',
                'status' => false
            ]);
        }

    }


    /**
     * @Route("/api/getCollaboratedUsercredential", name="api_get_collaborated_User_credential", methods={"GET"})
     */
    public function getCollaboratedUsercredential(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $Collaboratedusercredential = $this->getDoctrine()->getRepository(Collaboratedusercredential::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);
        
        if ($Collaboratedusercredential) {           
            return $this->json([
                'userId'=>$Collaboratedusercredential->getUserId(),
                'createDate'=>$Collaboratedusercredential->getCreateDate(),
                'modifiedDate'=>$Collaboratedusercredential->getModifiedDate(),
                'membership'=>['1'=>$Collaboratedusercredential->getMembership1(),
                '2'=>$Collaboratedusercredential->getMembership2(),
                '3'=>$Collaboratedusercredential->getMembership3()],
                'educationallevel'=>$Collaboratedusercredential->getEducationallevel(),
                'certificate'=>['1'=>$Collaboratedusercredential->getCertificate1(),
                '2'=>$Collaboratedusercredential->getCertificate2(),
                '3'=>$Collaboratedusercredential->getCertificate3()],
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }



    /**
     * @Route("/api/collaborateduserprofessionalbioSave", name="api_collaborated_Userprofessional_Save", methods={"POST"})
     */
    public function collaborateduserprofessionalbioSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $areaofexpertise1  = $request->query->get("areaofexpertise1");
        $areaofexpertise2  = $request->query->get("areaofexpertise2");
        $areaofexpertise3  = $request->query->get("areaofexpertise3");
        $experienceyears  = $request->query->get("experienceyears");
        $cvlink  = $request->query->get("cvlink");
        $biodescription  = $request->query->get("biodescription");
        $bioDiscipline  = $request->query->get("bioDiscipline");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $areaofexpertise1  = $request->request->get("areaofexpertise1");
            $areaofexpertise2  = $request->request->get("areaofexpertise2");
            $areaofexpertise3  = $request->request->get("areaofexpertise3");
            $experienceyears  = $request->request->get("experienceyears");
            $cvlink  = $request->request->get("cvlink");
            $biodescription  = $request->request->get("biodescription");
            $bioDiscipline  = $request->request->get("bioDiscipline");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
      
        $Collaborateduserprofessionalbio = $this->getDoctrine()->getRepository(Collaborateduserprofessionalbio::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if(empty($Collaborateduserprofessionalbio)){
            $Collaborateduserprofessionalbio = new Collaborateduserprofessionalbio();
        } 
            $Collaborateduserprofessionalbio->setUserId($Muser->getId());
            $Collaborateduserprofessionalbio->setCreateDate($createDate);
            $Collaborateduserprofessionalbio->setModifiedDate($modifiedDate);
            $Collaborateduserprofessionalbio->setAreaofexpertiseA($areaofexpertise1);
            $Collaborateduserprofessionalbio->setAreaofexpertiseB($areaofexpertise2);
            $Collaborateduserprofessionalbio->setAreaofexpertiseC($areaofexpertise3);
            $Collaborateduserprofessionalbio->setExperienceyears($experienceyears);
            $Collaborateduserprofessionalbio->setCvlink($cvlink);
            $Collaborateduserprofessionalbio->setBiodescription($biodescription);
            $Collaborateduserprofessionalbio->setBioDiscipline($bioDiscipline);
            $em->persist($Collaborateduserprofessionalbio);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated user professional bio saved successfully',
                'status' => true
            ]);            

    }



    /**
     * @Route("/api/collaboratedProfileAreaofInterest", name="api_collaborated_ProfileArea_of_Interest", methods={"POST"})
     */
    public function collaboratedProfileAreaofInterest(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $projectType  = $request->query->get("projectType");
        $description  = $request->query->get("description");
        $discipline1  = $request->query->get("discipline1");
        $language  = $request->query->get("language");
        $location1  = $request->query->get("location1");
        $campus  = $request->query->get("campus");
        $programLevel  = $request->query->get("programLevel");
        $programLength  = $request->query->get("programLength");
        $deliveryMethod  = $request->query->get("deliveryMethod");
        $credits  = $request->query->get("credits");
        $collaborationType  = $request->query->get("collaborationType");
        $disciplineB  = $request->query->get("disciplineB");
        $locationB  = $request->query->get("locationB");
        $disciplineC  = $request->query->get("disciplineC");
        $locationC  = $request->query->get("locationC");
        $disciplineD  = $request->query->get("disciplineD");
        $locationD  = $request->query->get("locationD");
        $rangeYearStart  = (int) $request->query->get("rangeYearStart");
        $rangeYearEnd  = (int) $request->query->get("rangeYearEnd");
        $rangeMonthStart  = $request->query->get("rangeMonthStart");
        $rangeMonthEnd  = $request->query->get("rangeMonthEnd");
        $universityName  = $request->query->get("universityName");
        $groupName  = $request->query->get("groupName");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $projectType  = $request->request->get("projectType");
            $description  = $request->request->get("description");
            $discipline1  = $request->request->get("discipline1");
            $language  = $request->request->get("language");
            $location1  = $request->request->get("location1");
            $campus  = $request->request->get("campus");
            $programLevel  = $request->request->get("programLevel");
            $programLength  = $request->request->get("programLength");
            $deliveryMethod  = $request->request->get("deliveryMethod");
            $credits  = $request->request->get("credits");
            $collaborationType  = $request->request->get("collaborationType");
            $disciplineB  = $request->request->get("disciplineB");
            $locationB  = $request->request->get("locationB");
            $disciplineC  = $request->request->get("disciplineC");
            $locationC  = $request->request->get("locationC");
            $disciplineD  = $request->request->get("disciplineD");
            $locationD  = $request->request->get("locationD");
            $rangeYearStart  = (int) $request->request->get("rangeYearStart");
            $rangeYearEnd  = (int) $request->request->get("rangeYearEnd");
            $rangeMonthStart  = $request->request->get("rangeMonthStart");
            $rangeMonthEnd  = $request->request->get("rangeMonthEnd");
            $universityName  = $request->request->get("universityName");
            $groupName  = $request->request->get("groupName");
        }

        
        if($this->validateDate($createDate) == false){
            $field_name = str_replace( '$', '', '$createDate' );
            return $this->json([
                'message'=>'Please enter valid date as '.$field_name.'',
                'status' => false
            ]);
        }
        $createDate = new DateTime($createDate);
       
       
        if($this->validateDate($modifiedDate) == false){
            $field_name = str_replace( '$', '', '$modifiedDate' );
            return $this->json([
                'message'=>'Please enter valid date as '.$field_name.'',
                'status' => false
            ]);
        }
        $modifiedDate = new DateTime($modifiedDate);

        if(empty(is_int($rangeYearStart))){
            $field_name = str_replace( '$', '', '$rangeYearStart' );
            return $this->json([
                'message'=>'Please enter valid integer as '.$field_name.'',
                'status' => false
            ]);
        }

        if(empty(is_int($rangeYearEnd))){
            $field_name = str_replace( '$', '', '$rangeYearEnd' );
            return $this->json([
                'message'=>'Please enter valid integer as '.$field_name.'',
                'status' => false
            ]);
        }

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
      
        // $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
        //     'userId' => $Muser->getId()
        // ]);

        if(empty($CollaboratedProfileAreaofInterest)){
            $CollaboratedProfileAreaofInterest = new CollaboratedProfileAreaofInterest();
        } 
            $CollaboratedProfileAreaofInterest->setUserId($Muser);
            $CollaboratedProfileAreaofInterest->setCreateDate($createDate);
            $CollaboratedProfileAreaofInterest->setModifiedDate($modifiedDate);
            $CollaboratedProfileAreaofInterest->setProjectType($projectType);
            $CollaboratedProfileAreaofInterest->setDescription($description);
            $CollaboratedProfileAreaofInterest->setDisciplineA($discipline1);
            $CollaboratedProfileAreaofInterest->setLanguage($language);
            $CollaboratedProfileAreaofInterest->setLocationA($location1);
            $CollaboratedProfileAreaofInterest->setCampus($campus);
            $CollaboratedProfileAreaofInterest->setProgramLevel($programLevel);
            $CollaboratedProfileAreaofInterest->setProgramLength($programLength);
            $CollaboratedProfileAreaofInterest->setDeliveryMethod($deliveryMethod);
            $CollaboratedProfileAreaofInterest->setCredits($credits);
            $CollaboratedProfileAreaofInterest->setCollaborationType($collaborationType);
            $CollaboratedProfileAreaofInterest->setDisciplineB($disciplineB);
            $CollaboratedProfileAreaofInterest->setLocationB($locationB);
            $CollaboratedProfileAreaofInterest->setDisciplineC($disciplineC);
            $CollaboratedProfileAreaofInterest->setLocationC($locationC);
            $CollaboratedProfileAreaofInterest->setDisciplineD($disciplineD);
            $CollaboratedProfileAreaofInterest->setLocationD($locationD);
            $CollaboratedProfileAreaofInterest->setRangeYearStart($rangeYearStart);
            $CollaboratedProfileAreaofInterest->setRangeYearEnd($rangeYearEnd);
            $CollaboratedProfileAreaofInterest->setRangeMonthStart($rangeMonthStart);
            $CollaboratedProfileAreaofInterest->setRangeMonthEnd($rangeMonthEnd);
            $CollaboratedProfileAreaofInterest->setUniversityName($universityName);
            $CollaboratedProfileAreaofInterest->setGroupName($groupName);

            $em->persist($CollaboratedProfileAreaofInterest);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated Profile AreaofInterest saved successfully',
                'status' => true
            ]);            

    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


    /**
     * @Route("/api/getCollaboratedProfileAreaofInterestAll", name="api_get_Collaborated_Profile_Areaof_Interest_All", methods={"GET"})
     */
    public function getCollaboratedProfileAreaofInterestAll(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findBy([
            'userId' => $Muser->getId()
        ]);

      
        
        if ($CollaboratedProfileAreaofInterest) { 
            
            $CollaboratedProfileAreaofInterest_array = array();


            foreach($CollaboratedProfileAreaofInterest as $CollaboratedProfileAreaofInterest_data){

                $CollaboratedProfileAreaofInterest_array[] = [
                    'userId'=>$CollaboratedProfileAreaofInterest_data->getUserId()->getId(),
                    'pkId'=>$CollaboratedProfileAreaofInterest_data->getId(),
                    'createDate'=>$CollaboratedProfileAreaofInterest_data->getCreateDate(),
                    'modifiedDate'=>$CollaboratedProfileAreaofInterest_data->getModifiedDate(),
                    'projectType'=>$CollaboratedProfileAreaofInterest_data->getProjectType(),
                    'description'=>$CollaboratedProfileAreaofInterest_data->getDescription(),
                    'discipline1'=>$CollaboratedProfileAreaofInterest_data->getDisciplineA(),
                    'language'=>$CollaboratedProfileAreaofInterest_data->getLanguage(),
                    'location1'=>$CollaboratedProfileAreaofInterest_data->getLocationA(),
                    'campus'=>$CollaboratedProfileAreaofInterest_data->getCampus(),
                    'programLevel'=>$CollaboratedProfileAreaofInterest_data->getProgramLevel(),
                    'programLength'=>$CollaboratedProfileAreaofInterest_data->getProgramLength(),
                    'deliveryMethod'=>$CollaboratedProfileAreaofInterest_data->getDeliveryMethod(),
                    'credits'=>$CollaboratedProfileAreaofInterest_data->getCredits(),
                    'collaborationType'=>$CollaboratedProfileAreaofInterest_data->getCollaborationType(),
                    'discipline2'=>$CollaboratedProfileAreaofInterest_data->getDisciplineB(),
                    'location2'=>$CollaboratedProfileAreaofInterest_data->getLocationB(),
                    'discipline3'=>$CollaboratedProfileAreaofInterest_data->getDisciplineC(),
                    'location3'=>$CollaboratedProfileAreaofInterest_data->getLocationC(),
                    'discipline4'=>$CollaboratedProfileAreaofInterest_data->getDisciplineD(),
                    'location4'=>$CollaboratedProfileAreaofInterest_data->getLocationD(),
                    'rangeYearStart'=>$CollaboratedProfileAreaofInterest_data->getRangeYearStart(),
                    'rangeYearEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeYearEnd(),
                    'rangeMonthStart'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthStart(),
                    'rangeMonthEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthEnd(),
                    'universityName'=>$CollaboratedProfileAreaofInterest_data->getUniversityName(),
                    'groupName'=>$CollaboratedProfileAreaofInterest_data->getGroupName(),
                    'status' => true
                ];
            }

            return $this->json([
                'CollaboratedProfileAreaofInterest'=>$CollaboratedProfileAreaofInterest_array,
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }

    /**
     * @Route("/api/getInterestPKfullUserDetails", name="api_get_Interest_PK_fullUserDetails", methods={"GET"})
     */
    public function getInterestPKfullUserDetails(Request $request)
    {   $token  = $request->query->get("token");
        $interestpk  = $request->query->get("interestpk");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        if(empty($interestpk)){
            return $this->json([
                'message'=>'Please provide collaborated profile area of interest ID',
                'status' => false
            ]);        
        } 

        $CollaboratedProfileAreaofInterest_data = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
            'id' => $interestpk
        ]);

        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'id' => $CollaboratedProfileAreaofInterest_data->getUserId()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        } 
        $Collaborateduserprofessionalbio = $this->getDoctrine()->getRepository(Collaborateduserprofessionalbio::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        $main_array = array();


        $CollaboratedUserProfileimage = $this->getDoctrine()->getRepository(CollaboratedUserProfileimage::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if ($Muser) {           
            $main_array['personalInformations']=[
                'name'=> $Muser->getPrefix().". ".$Muser->getFirstName()." ".$Muser->getMiddleName()." ".$Muser->getLastName(),
                'position'=>$Muser->getPosition(),
                'department'=>$Muser->getDepartment(),
                'thoughts'=>$Muser->getThoughts(),
                'status' => true
            ];
        }else{
            $main_array['personalInformations']=[
                'message'=>'User data not found',
                'status' => false
            ];
        }

        $institution_code = $Muser->getInstitutionCode();
        $MasterInstitutionLocationInfo = $this->getDoctrine()->getRepository(MasterInstitutionLocationInfo::class)->findOneBy(['institutecode' => $institution_code
        ]);
        if(!empty($MasterInstitutionLocationInfo)){
            $main_array['MasterInstitutionLocationInfo'] = [
            'institutionName' => $MasterInstitutionLocationInfo->getInstitutename(),
            'institutecity' => $MasterInstitutionLocationInfo->getInstitutecity(),
            'institutecountry' => $MasterInstitutionLocationInfo->getInstitutecountry(),
            'institutedepartment' => $MasterInstitutionLocationInfo->getInstitutedepartment(),
            'institutestate' => $MasterInstitutionLocationInfo->getInstitutestate(),
            'institutetimezone' => $MasterInstitutionLocationInfo->getInstitutetimezone()
            ];
        }else{
            $main_array['MasterInstitutionLocationInfo']=[
                'message'=>'Institution Location Info data not found',
                'status' => false
            ];
        }
        
        if ($CollaboratedUserProfileimage) {           
            $main_array['CollaboratedUserProfileimage']= [
                'userId'=>$CollaboratedUserProfileimage->getUserId(),
                'createdOn'=>$CollaboratedUserProfileimage->getCreatedOn(),
                'blobData'=>stream_get_contents($CollaboratedUserProfileimage->getBlobData()),
                'status' => true
            ];
        }else{
            $main_array['CollaboratedUserProfileimage']=[
                'message'=>'Collaborated user profile image data not found',
                'status' => false
            ];
        }

        $CommunicationPreferences = $this->getDoctrine()->getRepository(CommunicationPreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);


        if ($CommunicationPreferences) {           
            $main_array['CommunicationPreferences']=[
                'userId'=>$CommunicationPreferences->getUserId(),
                'createDate'=>$CommunicationPreferences->getCreateDate(),
                'modifiedDate'=>$CommunicationPreferences->getModifiedDate(),
                'primaryLanguageId'=>$CommunicationPreferences->getPrimaryLanguageId(),
                'primaryLanguageName'=>$CommunicationPreferences->getPrimaryLanguageName(),
                'secondaryLanguageId'=>$CommunicationPreferences->getSecondaryLanguageId(),
                'secondaryLanguageName'=>$CommunicationPreferences->getSecondaryLanguageName(),
                'tertiaryLanguageId'=>$CommunicationPreferences->getTertiaryLanguageId(),
                'tertiaryLanguageName'=>$CommunicationPreferences->getTertiaryLanguageName(),
                'emailAddress'=>$CommunicationPreferences->getEmailAddress(),
                'phoneNumber'=>$CommunicationPreferences->getPhoneNumber(),
                'website'=>$CommunicationPreferences->getWebsite(),
                'mobileNumber'=>$CommunicationPreferences->getMobileNumber(),
                'status' => true
            ];
        }else{
            $main_array['CommunicationPreferences']=[
                'message'=>'Communication preferences data not found',
                'status' => false
            ];
        }
      

        $CollaboratedLanguagePreferences = $this->getDoctrine()->getRepository(CollaboratedLanguagePreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);


        if ($CollaboratedLanguagePreferences) {           
            $main_array['CollaboratedLanguagePreferences']=[
                'userId'=>$CollaboratedLanguagePreferences->getUserId(),
                'createDate'=>$CollaboratedLanguagePreferences->getCreateDate(),
                'modifiedDate'=>$CollaboratedLanguagePreferences->getModifiedDate(),
                'languageName'=>$CollaboratedLanguagePreferences->getLanguageName(),
                'status' => true
            ];
        }else{
            $main_array['CollaboratedLanguagePreferences']=[
                'message'=>'Collaborated Language Preferences data not found',
                'status' => false
            ];
        }



        if ($Collaborateduserprofessionalbio) {           
            $main_array['Collaborateduserprofessionalbio']= [
                'userId'=>$Collaborateduserprofessionalbio->getUserId(),
                'createDate'=>$Collaborateduserprofessionalbio->getCreateDate(),
                'modifiedDate'=>$Collaborateduserprofessionalbio->getModifiedDate(),
                'areaofexpertise1'=>$Collaborateduserprofessionalbio->getAreaofexpertiseA(),
                'areaofexpertise2'=>$Collaborateduserprofessionalbio->getAreaofexpertiseB(),
                'areaofexpertise3'=>$Collaborateduserprofessionalbio->getAreaofexpertiseC(),
                'experienceyears'=>$Collaborateduserprofessionalbio->getExperienceyears(),
                'cvlink'=>$Collaborateduserprofessionalbio->getCvlink(),
                'biodescription'=>$Collaborateduserprofessionalbio->getBiodescription(),
                'bioDiscipline'=>$Collaborateduserprofessionalbio->getBioDiscipline(),
                'status' => true
            ];
        }else{
            $main_array['Collaborateduserprofessionalbio']= [
                'message'=> 'Collaborated user professional bio not found',
                'status' => false
            ];
        }

        $Collaboratedusercredential = $this->getDoctrine()->getRepository(Collaboratedusercredential::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);
        
        if ($Collaboratedusercredential) {           
            $main_array['Collaboratedusercredential']=[
                'userId'=>$Collaboratedusercredential->getUserId(),
                'createDate'=>$Collaboratedusercredential->getCreateDate(),
                'modifiedDate'=>$Collaboratedusercredential->getModifiedDate(),
                'membership1'=>$Collaboratedusercredential->getMembership1(),
                'membership2'=>$Collaboratedusercredential->getMembership2(),
                'membership3'=>$Collaboratedusercredential->getMembership3(),
                'educationallevel'=>$Collaboratedusercredential->getEducationallevel(),
                'certificate1'=>$Collaboratedusercredential->getCertificate1(),
                'certificate2'=>$Collaboratedusercredential->getCertificate2(),
                'certificate3'=>$Collaboratedusercredential->getCertificate3(),
                'status' => true
            ];
        }else{
            $main_array['Collaboratedusercredential']=[
                'message'=>'Collaborated user credential data not found',
                'status' => false
            ];
        }
         
         if ($CollaboratedProfileAreaofInterest_data) { 
 
 
            $main_array['Collaborateduserprofessionalbio']= [
                     'userId'=>$CollaboratedProfileAreaofInterest_data->getUserId()->getId(),
                     'pkId'=>$CollaboratedProfileAreaofInterest_data->getId(),
                     'createDate'=>$CollaboratedProfileAreaofInterest_data->getCreateDate(),
                     'modifiedDate'=>$CollaboratedProfileAreaofInterest_data->getModifiedDate(),
                     'projectType'=>$CollaboratedProfileAreaofInterest_data->getProjectType(),
                     'description'=>$CollaboratedProfileAreaofInterest_data->getDescription(),
                     'discipline1'=>$CollaboratedProfileAreaofInterest_data->getDisciplineA(),
                     'language'=>$CollaboratedProfileAreaofInterest_data->getLanguage(),
                     'location1'=>$CollaboratedProfileAreaofInterest_data->getLocationA(),
                     'campus'=>$CollaboratedProfileAreaofInterest_data->getCampus(),
                     'programLevel'=>$CollaboratedProfileAreaofInterest_data->getProgramLevel(),
                     'programLength'=>$CollaboratedProfileAreaofInterest_data->getProgramLength(),
                     'deliveryMethod'=>$CollaboratedProfileAreaofInterest_data->getDeliveryMethod(),
                     'credits'=>$CollaboratedProfileAreaofInterest_data->getCredits(),
                     'collaborationType'=>$CollaboratedProfileAreaofInterest_data->getCollaborationType(),
                     'discipline2'=>$CollaboratedProfileAreaofInterest_data->getDisciplineB(),
                     'location2'=>$CollaboratedProfileAreaofInterest_data->getLocationB(),
                     'discipline3'=>$CollaboratedProfileAreaofInterest_data->getDisciplineC(),
                     'location3'=>$CollaboratedProfileAreaofInterest_data->getLocationC(),
                     'discipline4'=>$CollaboratedProfileAreaofInterest_data->getDisciplineD(),
                     'location4'=>$CollaboratedProfileAreaofInterest_data->getLocationD(),
                     'rangeYearStart'=>$CollaboratedProfileAreaofInterest_data->getRangeYearStart(),
                     'rangeYearEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeYearEnd(),
                     'rangeMonthStart'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthStart(),
                     'rangeMonthEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthEnd(),
                     'universityName'=>$CollaboratedProfileAreaofInterest_data->getUniversityName(),
                     'groupName'=>$CollaboratedProfileAreaofInterest_data->getGroupName(),
                     'status' => true
                 ];
          
         }else{
            $main_array['Collaborateduserprofessionalbio']=[
                 'message'=>'User data not found',
                 'status' => false
             ];
         }

        if ($main_array) {  
        return $this->json([
            'result'=>$main_array,
            'status' => true
        ]);
        }else{
        return $this->json([
            'message'=>'Unable to find user informations',
            'status' => false
        ]);
        }
    }




    /**
     * @Route("/api/getUsergeneralAreaofInterest", name="api_get_User_general_AreaofInterest", methods={"GET"})
     */
    public function getUsergeneralAreaofInterest(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        $pk_area_of_interest= $request->query->get("pk_area_of_interest");
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
   
        if(empty($pk_area_of_interest)){
            return $this->json([
                'message'=>'Unable to find primary id information',
                'status' => false
            ]);        
        }
        $CollaboratedProfileAreaofInterest_data = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
           'id'=>$pk_area_of_interest
        ]);

        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'id' => $CollaboratedProfileAreaofInterest_data->getUserId()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        } 

        if ($Muser) {           
            $main_array['personalInformations']=[
                'name'=> $Muser->getPrefix().". ".$Muser->getFirstName()." ".$Muser->getMiddleName()." ".$Muser->getLastName(),
                'position'=>$Muser->getPosition(),
                'status' => true
            ];
        }else{
            $main_array['personalInformations']=[
                'message'=>'User data not found',
                'status' => false
            ];
        }

        $CollaboratedUserProfileimage = $this->getDoctrine()->getRepository(CollaboratedUserProfileimage::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if ($CollaboratedUserProfileimage) {           
            $main_array['CollaboratedUserProfileimage']= [
                'blobData'=>stream_get_contents($CollaboratedUserProfileimage->getBlobData()),
                'status' => true
            ];
        }else{
            $main_array['CollaboratedUserProfileimage']=[
                'message'=>'Collaborated user profile image data not found',
                'status' => false
            ];
        }
      
        
        if ($CollaboratedProfileAreaofInterest_data) { 

            $main_array['Collaborateduserprofessionalbio']= [
                    'userId'=>$CollaboratedProfileAreaofInterest_data->getUserId()->getId(),
                    'pkId'=>$CollaboratedProfileAreaofInterest_data->getId(),
                    'projectType'=>$CollaboratedProfileAreaofInterest_data->getProjectType(),
                    'description'=>$CollaboratedProfileAreaofInterest_data->getDescription(),
                    'discipline1'=>$CollaboratedProfileAreaofInterest_data->getDisciplineA(),
                    'location1'=>$CollaboratedProfileAreaofInterest_data->getLocationA(),
                    'programLength'=>$CollaboratedProfileAreaofInterest_data->getProgramLength(),
                    'deliveryMethod'=>$CollaboratedProfileAreaofInterest_data->getDeliveryMethod(),
                    'collaborationType'=>$CollaboratedProfileAreaofInterest_data->getCollaborationType(),
                    'status' => true
                ];
         
        }else{
            $main_array['Collaborateduserprofessionalbio']=[
                'message'=>'User data not found',
                'status' => false
            ];
        }
        

        if ($main_array) {  
            return $this->json([
                'result'=>$main_array,
                'status' => true
            ]);
            }else{
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);
            }
    }








    /**
     * @Route("/api/getCollaboratedProfileAreaofInterestSingle", name="api_get_Collaborated_Profile_Areaof_Interest_Single", methods={"GET"})
     */
    public function getCollaboratedProfileAreaofInterestSingle(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        $pk_area_of_interest= $request->query->get("pk_area_of_interest");
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        if(empty($pk_area_of_interest)){
            return $this->json([
                'message'=>'Unable to find primary id information',
                'status' => false
            ]);        
        }
        $CollaboratedProfileAreaofInterest_data = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneBy([
           'id'=>$pk_area_of_interest
        ]);

      
        
        if ($CollaboratedProfileAreaofInterest_data) { 


                $CollaboratedProfileAreaofInterest_array = [
                    'userId'=>$CollaboratedProfileAreaofInterest_data->getUserId()->getId(),
                    'pkId'=>$CollaboratedProfileAreaofInterest_data->getId(),
                    'createDate'=>$CollaboratedProfileAreaofInterest_data->getCreateDate(),
                    'modifiedDate'=>$CollaboratedProfileAreaofInterest_data->getModifiedDate(),
                    'projectType'=>$CollaboratedProfileAreaofInterest_data->getProjectType(),
                    'description'=>$CollaboratedProfileAreaofInterest_data->getDescription(),
                    'discipline1'=>$CollaboratedProfileAreaofInterest_data->getDisciplineA(),
                    'language'=>$CollaboratedProfileAreaofInterest_data->getLanguage(),
                    'location1'=>$CollaboratedProfileAreaofInterest_data->getLocationA(),
                    'campus'=>$CollaboratedProfileAreaofInterest_data->getCampus(),
                    'programLevel'=>$CollaboratedProfileAreaofInterest_data->getProgramLevel(),
                    'programLength'=>$CollaboratedProfileAreaofInterest_data->getProgramLength(),
                    'deliveryMethod'=>$CollaboratedProfileAreaofInterest_data->getDeliveryMethod(),
                    'credits'=>$CollaboratedProfileAreaofInterest_data->getCredits(),
                    'collaborationType'=>$CollaboratedProfileAreaofInterest_data->getCollaborationType(),
                    'discipline2'=>$CollaboratedProfileAreaofInterest_data->getDisciplineB(),
                    'location2'=>$CollaboratedProfileAreaofInterest_data->getLocationB(),
                    'discipline3'=>$CollaboratedProfileAreaofInterest_data->getDisciplineC(),
                    'location3'=>$CollaboratedProfileAreaofInterest_data->getLocationC(),
                    'discipline4'=>$CollaboratedProfileAreaofInterest_data->getDisciplineD(),
                    'location4'=>$CollaboratedProfileAreaofInterest_data->getLocationD(),
                    'rangeYearStart'=>$CollaboratedProfileAreaofInterest_data->getRangeYearStart(),
                    'rangeYearEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeYearEnd(),
                    'rangeMonthStart'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthStart(),
                    'rangeMonthEnd'=>$CollaboratedProfileAreaofInterest_data->getRangeMonthEnd(),
                    'universityName'=>$CollaboratedProfileAreaofInterest_data->getUniversityName(),
                    'groupName'=>$CollaboratedProfileAreaofInterest_data->getGroupName(),
                    'status' => true
                ];
          
            
            return $this->json([
                'CollaboratedProfileAreaofInterest'=>$CollaboratedProfileAreaofInterest_array,
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }


    /**
     * @Route("/api/getInterestMatchConditionCases", name="api_get_AreaofInterest_ConditionCases", methods={"GET"})
     */
    public function getInterestMatchConditionCases(Request $request)
    {
        $token  = $request->query->get("token");

        $token_error= $this->tokenVerificationCheck($token);
        $projectType=  $request->query->get('projectType');
        $locationA=  $request->query->get('locationA');
        $disciplineA= $request->query->get('disciplineA');
        $language=  $request->query->get('language');
        $collaborationType=  $request->query->get('collaborationType');

        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }    
        $sql = "SELECT ia.id as interest_pk,ia.universityName, ur.first_name,ur.position, ln.inst_name,ln.inst_city,ln.inst_state,ln.inst_state  FROM sym_api_admin_user_master.collaborated_profileareaofinterest as ia  join sym_api_admin_user_master.fos_user as ur on ur.id = ia.userId 
        join sym_api_admin_user_master.institution_location_info as ln on ur.institution_name  = ln.inst_code WHERE (ia. projectType  = :projectType) or (ia.discipline1  = :disciplineA ) or (ia.location1 = :locationA )
        or (ia.language = :language) or (ia. 	collaborationType = :collaborationType)";
        $params['projectType'] = $projectType;
        $params['locationA'] = $locationA;
        $params['projectType'] = $projectType;
        $params['disciplineA'] = $disciplineA;
        $params['language'] = $language;
        $params['collaborationType'] = $collaborationType;
        $stmt =$this->getDoctrine()->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();

        if(empty($result)){
            return $this->json([
                'message'=>'No data found',
                'status' => false
            ]);        
        }        
        if ($result) {             
            $result_array = array();
            foreach($result as $result_data){

                $result_array[] = [
                    'interest_pk'=>$result_data['interest_pk'],
                    'universityName'=>$result_data['universityName'],
                    'first_name'=>$result_data['first_name'],
                    'position'=>$result_data['position'],
                    'inst_name'=>$result_data['inst_name'],
                    'inst_city'=>$result_data['inst_city'],
                    'inst_state'=>$result_data['inst_state'],
                    'status' => true
                ];
            }
            return $this->json([
                'result_array'=>$result_array,
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }


    /**
     * @Route("/api/getCollaborateduserprofessionalbio", name="api_get_Collaborated_user_professionalbio", methods={"GET"})
     */
    public function getCollaborateduserprofessionalbio(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $Collaborateduserprofessionalbio = $this->getDoctrine()->getRepository(Collaborateduserprofessionalbio::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);
        
        if ($Collaborateduserprofessionalbio) {           
            return $this->json([
                'userId'=>$Collaborateduserprofessionalbio->getUserId(),
                'createDate'=>$Collaborateduserprofessionalbio->getCreateDate(),
                'modifiedDate'=>$Collaborateduserprofessionalbio->getModifiedDate(),
                'areaofexpertise1'=>['1'=>$Collaborateduserprofessionalbio->getAreaofexpertiseA(),
                '2'=>$Collaborateduserprofessionalbio->getAreaofexpertiseB(),
                '3'=>$Collaborateduserprofessionalbio->getAreaofexpertiseC()],
                'experienceyears'=>$Collaborateduserprofessionalbio->getExperienceyears(),
                'cvlink'=>$Collaborateduserprofessionalbio->getCvlink(),
                'biodescription'=>$Collaborateduserprofessionalbio->getBiodescription(),
                'bioDiscipline'=>$Collaborateduserprofessionalbio->getBioDiscipline(),
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }


    /**
     * @Route("/api/getLanguageList", name="api_get_language_list", methods={"GET"})
     */
    public function getLanguageList(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $MasterLanguage = $this->getDoctrine()->getRepository(MasterLanguage::class)->findBy([],['id'=>'ASC']);
        
        if ($MasterLanguage) { 
            $language_array = [];
            foreach($MasterLanguage as $MasterLanguage_data){
                $language_array[]=   [
                'Id'=>$MasterLanguage_data->getId(),
                'LanguageName'=>$MasterLanguage_data->getLanguagename()
                ];
            }
            return $this->json([
                'language_array'=>$language_array,
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'Language data not found',
                'status' => false
            ]);
        }
    }

    /**
     * @Route("/api/collaboratedUserProfileimageSave", name="api_collaborated_UserProfile_image_Save", methods={"POST"})
     */
    public function collaboratedUserProfileimageSave(Request $request)
    {
      
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createdOn  = $request->query->get("createdOn");
        $blobData  = $request->query->get("blobData");

        if(empty($blobData)){
            $blobData  = $request->request->get("blobData");
        }
    
        $createdOn = new DateTime($createdOn);
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        if(empty($blobData)){
            return $this->json([
                'message'=>'File not found',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $CollaboratedUserProfileimage = $this->getDoctrine()->getRepository(CollaboratedUserProfileimage::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);
       
        if(empty($CollaboratedUserProfileimage)){
            $CollaboratedUserProfileimage = new CollaboratedUserProfileimage();        
        }
        
            $CollaboratedUserProfileimage->setUserId($Muser->getId());
            $CollaboratedUserProfileimage->setCreatedOn($createdOn);
            $CollaboratedUserProfileimage->setBlobData($blobData);        
            $em->persist($CollaboratedUserProfileimage);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated user profile image saved successfully',
                'status' => true
            ]);

    }

    /**
     * @Route("/api/getCollaboratedUserProfileimage", name="api_get_collaborated_User_Profileimage", methods={"GET"})
     */
    public function getCollaboratedUserProfileimage(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $CollaboratedUserProfileimage = $this->getDoctrine()->getRepository(CollaboratedUserProfileimage::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);
        
        if ($CollaboratedUserProfileimage) {           
            return $this->json(['CollaboratedUserProfileimage'=>[
                'userId'=>$CollaboratedUserProfileimage->getUserId(),
                'createdOn'=>$CollaboratedUserProfileimage->getCreatedOn(),
                'blobData'=>stream_get_contents($CollaboratedUserProfileimage->getBlobData()),                
            ],'status' => true]);
        }else{
            return $this->json([
                'message'=>'Collaborated user profile image data not found',
                'status' => false
            ]);
        }
    }

    /**
     * @Route("/api/collaboratedLanguagePreferencesSave", name="api_collaborated_Language_PreferencesSave_Save", methods={"POST"})
     */
    public function collaboratedLanguagePreferencesSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $languageName  = $request->query->get("languageName");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $languageName  = $request->request->get("languageName");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);

        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        if(empty($user)){
            return $this->json([
                'message'=>'Please enter user id',
                'status' => false
            ]);        
        }
        if(empty($languageName)){
            return $this->json([
                'message'=>'Language  name not given',
                'status' => false
            ]);        
        }
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        } 
        $CollaboratedLanguagePreferences = $this->getDoctrine()->getRepository(CollaboratedLanguagePreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);

        if(empty($CollaboratedLanguagePreferences)){
            $CollaboratedLanguagePreferences = new CollaboratedLanguagePreferences();
        }         

            $CollaboratedLanguagePreferences->setUserId($Muser->getId());
            $CollaboratedLanguagePreferences->setCreateDate($createDate);
            $CollaboratedLanguagePreferences->setModifiedDate($modifiedDate);
            $CollaboratedLanguagePreferences->setLanguageName($languageName);
            $em->persist($CollaboratedLanguagePreferences);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated language preferences saved successfully',
                'status' => true
            ]);            

    }


    /**
     * @Route("/api/getCollaboratedLanguagePreferences", name="api_get_collaborated_language_preferences", methods={"GET"})
     */
    public function getCollaboratedLanguagePreferences(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $CollaboratedLanguagePreferences = $this->getDoctrine()->getRepository(CollaboratedLanguagePreferences::class)->findOneBy([
            'userId' => $Muser->getId()
        ]);


        if ($CollaboratedLanguagePreferences) {           
            return $this->json([
                'userId'=>$CollaboratedLanguagePreferences->getUserId(),
                'createDate'=>$CollaboratedLanguagePreferences->getCreateDate(),
                'modifiedDate'=>$CollaboratedLanguagePreferences->getModifiedDate(),
                'languageName'=>$CollaboratedLanguagePreferences->getLanguageName(),
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }


    /**
     * @Route("/api/getPersonalInformation", name="api_get_personal_information", methods={"GET"})
     */
    public function getPersonalInformation(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        
        if ($Muser) {           
            return $this->json([
                'name'=> $Muser->getPrefix().". ".$Muser->getFirstName()." ".$Muser->getMiddleName()." ".$Muser->getLastName(),
                'position'=>$Muser->getPosition(),
                'department'=>$Muser->getDepartment(),
                'thoughts'=>$Muser->getThoughts(),
                'status' => true
            ]);
        }else{
            return $this->json([
                'message'=>'User data not found',
                'status' => false
            ]);
        }
    }

    /**
     * @Route("/api/getInstitutionProfileData", name="api_get_institution_profile_data", methods={"GET"})
     */
    public function getInstitutionProfileData(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
        $Muser = $this->getDoctrine()->getRepository(FosUser::class)->findOneBy([
            'localFosId' => $user->getId(),'institutionCode' => $user->getInstitutionName()
        ]);
        if(empty($Muser)){
            return $this->json([
                'message'=>'Unable to find user informations',
                'status' => false
            ]);        
        }
        $institution_code = $Muser->getInstitutionCode();
        $MasterInstitutionLocationInfo = $em->getRepository(MasterInstitutionLocationInfo::class)->findOneBy(['institutecode' => $institution_code
        ]);
        if(!empty($MasterInstitutionLocationInfo)){
        $result = array(
            'institutionName' => $MasterInstitutionLocationInfo->getInstitutename(),
            'duration'=>$MasterInstitutionLocationInfo->getFounded(),
            'location' => $MasterInstitutionLocationInfo->getInstitutecity().','.     $MasterInstitutionLocationInfo->getInstitutestate(),
            'institutecountry' => $MasterInstitutionLocationInfo->getInstitutecountry(),
            'institutetimezone' => $MasterInstitutionLocationInfo->getInstitutetimezone()
              );

        return $this->json([
            'Institution' => $result,
            'status' => true
        ]);
        }else{
            return $this->respondWithErrors(sprintf('Institution profile data is not available'));
        }
        
    }

    /**
     * @Route("/api/getUserDetails", name="api_getUserDetails", methods={"GET"})
     */
    public function getUserDetails(Request $request)
    {
        $token  = $request->query->get("token");
        $token_error= $this->tokenVerificationCheck($token);
        if($token_error['status'] == false){
            return $this->json($token_error);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['apiToken'=>$token]);
        
        if (!empty($user)) {
            $this->userDataSave($user);
            $result = $this->serializeUsers($user);

            return $this->json([
                'user' => $result
            ]);
        }
        return $this->respondWithErrors(sprintf('User is not available'));
    }

    /**
     * @Route("/getProfileDetails", name="api_getProfileDetails", methods={"GET"})
     */
    public function getProfileDetails(Request $request)
    {
        // $token  = $request->query->get("token");
        // $token_error= $this->tokenVerificationCheck($token);
        // if($token_error['status'] == false){
        //     return $this->json($token_error);
        // }
    }

    private function tokenVerificationCheck($token)
    {            
        $time_out =$this->container->getParameter('time_out');       
        if(empty($token)){
            return [
                'message'=>'Token not found',
                'status' => false
            ];  
        }else{

            $user = $this->getDoctrine()->getRepository(User::class)->findOneByApiToken($token);
            if(empty($user)) {
                return [
                    'message'=>'Invalid token please try again',
                    'status' => false
                ];
            }else{
                $startTime = new DateTime();          
                $last_login = $user->getLastLogin()->format('d-m-Y H:i:s');                
                $endTime = date("d-m-Y H:i:s", strtotime($last_login) + $time_out);
                $endTime = new DateTime($endTime);
             
               if($startTime > $endTime){
                    return [
                        'message'=>'Token expired please try again',
                        'status' => false
                    ];
               }else{
                    return [
                        'message'=>'Token found',
                        'status' => true
                    ];
               }
            }
        }    
      
    }

    private function serializeUsers(User $usr)
    {
        $roles = $usr->getRoles();

        if (count($roles)) {
            $roles = array_values(array_filter($roles, function($val) {
                return $val != 'ROLE_USER';
            }));
        }
        
        
        
        return array(
            'institutionEmail' => $usr->getEmail(),
            'prefix' => $usr->getPrefix(),
            'firstName' => $usr->getFirstname(),
            'middleName' => $usr->getMiddleName(),
            'lastName' => $usr->getLastname(),
            'userName' => $usr->getUsername(),
            'institutionName' => $usr->getInstitutionName(),
            'roles' => count($roles) ? $roles[0] : "",
            'phone' => $usr->getPhone(),
            'position' => $usr->getPosition(),
            'ssn' => $usr->getSsn(),
            'veteran' => $usr->getVetran(),
            'ethnicity' => $usr->getEthinicity(),
            'dateOfBirth' => $usr->getDateOfBirth(),
            'gender' => $usr->getGender(),
            'emergencyContact' => $usr->getEmergencyContactPerson(),
            'emergencyContactPhone' => $usr->getEmergencyContactPhone(),
            'address1' => $usr->getAddress1(),
            'address2' => $usr->getAddress2(),
            'city' => $usr->getCity(),
            'state' => $usr->getState(),
            'zip' => $usr->getZip(),
            'password' => $usr->getDummyPassword(),
			'department' => $usr->getDepartment()
            //I have tried using getter method to retrieve image value here but I cannot because image is related to users
        );
    }


  

    /**
     * @Route("/listUsers", name="api_listUsers", methods={"GET"})
     */
    public function listUsers(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        return $this->json([
            'user' => $repository->findAll()
        ]);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function response($data, $headers = [])
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $errors
     * @param $headers
     * @return JsonResponse
     */
    public function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }


    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $success
     * @param $headers
     * @return JsonResponse
     */
    public function respondWithSuccess($success, $headers = [])
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }


    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondUnauthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondValidationError($message = 'Validation errors')
    {
        return $this->setStatusCode(422)->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(404)->respondWithErrors($message);
    }

    /**
     * Returns a 201 Created
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(201)->response($data);
    }

    // this method allows us to accept JSON payloads in POST requests
    // since Symfony 4 doesn’t handle that automatically:

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }


    /**
     * @Route("/api/updateUserProfile", name="api_update_user_profile", methods={"POST"})
     */
    public function updateUserProfile(UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        
        $errors = [];
        if (!$request->request->get('email')) {
            $errors[] = 'Username. must be required for update user profile data';
        }

        if ($request->request->get('password') && strlen($request->request->get('password')) < 8) {
            $errors[] = "Password should be at least 8 characters.";
        }

       
        if (!$errors) {
            
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email' => $request->request->get('email'),
            ]);

            if (!$user) {
                $errors[] = "User not found.";
                return $this->json([
                    'errors' => $errors
                ], 400);
            }
            
            if ($request->request->get('prefix')) {
              
                $user->setPrefix($request->request->get('prefix'));
            }
            if ($request->request->get('firstName')) {
                $user->setFirstName($request->request->get('firstName'));
            }
            if ($request->request->get('middleName')) {
                $user->setMiddleName($request->request->get('middleName'));    
            }
            if ($request->request->get('lastName')) {
                $user->setLastName($request->request->get('lastName'));
            }
            if ($request->request->get('phone')) {
                $user->setPhone($request->request->get('phone'));
            }
            if ($request->request->get('username')) {
                $user->setUserName($request->request->get('username'));
            }
            if ($request->request->get('email')) {
                $user->setEmail($request->request->get('email'));
            }
            if ($request->request->get('institutionName')) {
               $user->setInstitutionName($request->request->get('institutionName'));
            }
            if ($request->request->get('ssn')) {
               $user->setSsn($request->request->get('ssn'));
            }
            if ($request->request->get('vetran')) {
               $user->setVetran((strtolower($request->request->get('vetran')) == 'yes' || $request->request->get('vetran') == 1) ? 1 : 0);
            }
            if ($request->request->get('ethnicity')) {
               $user->setEthinicity($request->request->get('ethnicity'));
            }
            if ($request->request->get('dateOfBirth')) {
                $user->setDateOfBirth(new DateTime($request->request->get('dateOfBirth')));

            }
            if ($request->request->get('gender')) {
                 $user->setGender(ucfirst($request->request->get('gender')));

            }
            if ($request->request->get('emergencyContactPerson')) {
                 $user->setEmergencyContactPerson($request->request->get('emergencyContactPerson'));

            }
            if ($request->request->get('emergencyContactPhone')) {
                 $user->setEmergencyContactPhone($request->request->get('emergencyContactPhone'));

            }
            if ($request->request->get('address1')) {
                $user->setAddress1($request->request->get('address1'));
            }
            if ($request->request->get('address2')) {
                 $user->setAddress2($request->request->get('address2'));
            }
            if ($request->request->get('city')) {
                 $user->setCity($request->request->get('city'));
            }
            if ($request->request->get('state')) {
                $user->setState($request->request->get('state'));
            }
            if ($request->request->get('zip')) {
                $user->setZip($request->request->get('zip'));
            }

            if ($request->request->get('position')) {
                $user->setPosition($request->request->get('position'));
            }

            if ($request->request->get('role')) {

                $userRole = $this->getDoctrine()->getRepository(Group::class)->findOneBy([
                    'name' => $request->request->get('role')
                ]);
                
                if (!is_null($userRole)) {

                    if (count($user->getGroups())) {
                        foreach($user->getGroups() as $group) {
                            
                            if (in_array($group->getName(), [RoleModel::ROLE_STUDENT, RoleModel::ROLE_FACULTY, RoleModel::ROLE_ADMINISTRATOR])) {
                                $user->removeGroup($group);
                            }
                        }
                    }
                   
                    $user->addGroup($userRole);
                } 
            }

            if ($request->request->get('password')) {
                $encodedPassword = $passwordEncoder->encodePassword($user, $request->request->get('password'));
                $user->setPlainPassword($request->request->get('password'));
                $user->setPassword($encodedPassword);
                $user->setDummyPassword($request->request->get('password'));
            }
            
            $em = $this->getDoctrine()->getManager();
            try {

                $em->persist($user);
                $em->flush();


                //$this->userManager->updateUserToExternalApi($user->getUserName());
                $this->userManager->curSendPost($user);

                return $this->respondWithSuccess(sprintf('User profile %s successfully updated', $user->getUsername()));
               

            } catch (\Exception $e) {
                
                $errors[] = "Unable to update the user at this time.";
                $errors[] = $e->getMessage();
            }
        }
        return $this->json([
            'errors' => $errors
        ], 400);
    }

    /**
     * @Route("/api/forget-password", name="api_forget_password", methods={"GET"})
     */
    public function forgetPassword(Request $request, MailerInterface $mailer) 
    {

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(User::class)->createQueryBuilder('u');
        
        
        $user = $qb->select('u')
                    ->where('u.email = :username OR u.username = :username')
                    ->setParameter(':username', $request->query->get('user'))
                    ->getQuery()
                    ->getOneOrNullResult();
     
      
        $errors = [];


        if (!$user) {
            $errors[] = "User not found.";
            return $this->json([
                'errors' => $errors
            ], 400);
        }

        $token = md5(uniqid($user->getUsername(), true)); 
        $user->setConfirmationToken($token);
        $user->setPasswordRequestedAt(new \DateTime());

        try {
            $em->persist($user);
            $em->flush();
    
            $name = $user->getFullNameWithPrefix();
            $resetPasswordLink = "http://23.99.141.44/changepassword?token=${token}";
            $content = "<h1>Hi, ${name} </h1> </br> <p>You can reset your password by clicking the link below: </br> ${resetPasswordLink} </p>";
            $email = (new Email())
                        ->from('toweredtest@gmail.com')
                        ->to($user->getEmail())
                        ->subject('Reset Password Token')
                        ->html($content);
            $mailer->send($email);

            return $this->json([
                            'status' => 200,
                            'success' => 'Reset password link sent to your registered email.'
                        ], 200);

        } catch (\Exception $e) {
            
            $errors[] = "Unable to send reset password link email at this time.";
            $errors[] = $e->getMessage();
        }

        $em->persist($user);
        $em->flush();

    
        return $this->json([
            'errors' => $errors
        ], 400);
    
    }

    /**
     * @Route("/api/reset-password/{token}", name="api_reset_password", methods={"POST"})
     */
    public function resetPassword(UserPasswordEncoderInterface $passwordEncoder, Request $request, $token) 
    {
        
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(['confirmationToken' => $token]); 

        if (null === $user) {                        
            return $this->json([
                'errors' => [ 'Reset password link not found.' ]
            ], 400);
        } 

        if ($user) {

            $datetime1 = $user->getPasswordRequestedAt(); 
      
            $datetime2 = new DateTime("now");

            $diff = $datetime2->diff($datetime1)->format("%a");

            if ($diff > 5) {
                return $this->json([
                    'errors' => [ 'Reset password link was expired.' ]
                ], 400);
            }
        } 


        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');

        if ($password != $confirmPassword) {

            return $this->json([
                'errors' => [ 'Password not matched']
            ], 400);
        }
        
        try {    
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();  

            return $this->respondWithSuccess('Your new password was updated successfully'); 

        } catch (\Exception $e) {
                
            $errors[] = "Unable to reset password at this time";
            $errors[] = $e->getMessage();

            return $this->json([
                'errors' => $errors
            ], 400);
        }
    }

    /**
     * @Route("/api/send-test-mail", name="api_test_mail", methods={"GET"})
     */
    public function sendTestMail(MailerInterface $mailer)
    {
        $name = "Mr. John Peter";
        $resetPasswordLink = "http://test.com";
        $toEmail = 'test@mail.com';
        
        $content = "<h1>Hi, ${name} </h1> </br> <p>You can reset your password by clicking the link below: </br> ${resetPasswordLink} </p>";
        $email = (new Email())
                    ->from('toweredtest@gmail.com')
                    ->to($toEmail)
                    ->subject('Reset Password Token')
                    ->html($content);
        $mailer->send($email);

        return new JsonResponse(['status' => true]);
    }

    /**
     * @Route("/api/image-get-logos", name="api_get_logo_images", methods={"GET"})
     */
    public function getLogoImages(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository(Settings::class)->findById(1);

    
        // if ($settings) {
        //     if (isset($settings['loginLogo'])) {
        //         $settings['loginLogo'] = $request->getHost() . ":" . $request->getPort() . "/" . $settings['loginLogo'];
        //     }
            
        //     if (isset($settings['adminDashboardLogo'])) {
        //         $settings['adminDashboardLogo'] = $request->getHost() . ":" . $request->getPort() . "/" . $settings['adminDashboardLogo'];
        //     }
        // }

        return new JsonResponse([
            'logo' => 'http://' . $request->getHost() . ":" . $request->getPort() . "/" . $settings['loginLogo']
        ]);

    }

    /**
     * @Route("/api/institution-profile", name="api_institution_profile", methods={"GET"})
     */
    public function getInstitutionProfile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository(InstitutionProfile::class)->findById(1);
       

        if ($profile) {
            if (isset($profile['insProfileImage'])) {
                $profile['insProfileImage'] = $request->getHost() . ":" . $request->getPort() . "/" . $profile['insProfileImage'];
            }
        }


        return new JsonResponse([
            'data' => $profile
        ]);

        return new JsonResponse([
            'id' => $profile->getId(),
            'institutionName'=> $profile->getInstitutionName(),
            'campusName'=> $profile->getCampusName(),
            'founded'=> $profile->getFounded(),
            'insType'=> $profile->getInsType(),
            'language'=> $profile->getLanguage(),
            'president'=> $profile->getPresident(),
            'academicCalendar'=> $profile->getAcademicCalendar(),
            'otherLanguages'=> $profile->getOtherLanguages(),
            'totalEmployees'=> $profile->getTotalEmployees(),
            'alumini'=> $profile->getAlumini(),
            'overview'=> $profile->getOverview(),
            'institutionContact'=> [
                'officeNumber' => $profile->getInstitutionContact()->getOfficeNumber(),
                'mailingName' => $profile->getInstitutionContact()->getMailingName(),
                'faxNumber' => $profile->getInstitutionContact()->getFaxNumber(),
                'department' => $profile->getInstitutionContact()->getDepartment(),
                'website' => $profile->getInstitutionContact()->getWebsite(),
                'email' => $profile->getInstitutionContact()->getEmail(),
                'address1' => $profile->getInstitutionContact()->getAddress1(),
                'address2' => $profile->getInstitutionContact()->getAddress2(),
                'city' => $profile->getInstitutionContact()->getCity(),
                'state' => $profile->getInstitutionContact()->getState(),
                'postalCode' => $profile->getInstitutionContact()->getPostalCode(),
                'new' => $profile->getInstitutionContact()->getNew()
            ],
            'institutionLocation'=> [
                'address1' => $profile->getInstitutionLocation()->getAddress1(),
                'address2' => $profile->getInstitutionLocation()->getAddress2(),
                'city' => $profile->getInstitutionLocation()->getCity(),
                'state' => $profile->getInstitutionLocation()->getState(),
                'postalCode' => $profile->getInstitutionLocation()->getPostalCode(),
				'timezone' => $profile->getInstitutionLocation()->getTimezone()
            ],
            'studentDetails'=> [
                'term' => $profile->getStudentDetails()->getTerm(),
                'year' => $profile->getStudentDetails()->getYear(),
                'totalStudents' => $profile->getStudentDetails()->getTotalStudents(),
                'femaleStudents' => $profile->getStudentDetails()->getFemaleStudents(),
                'maleStudents' => $profile->getStudentDetails()->getMaleStudents(),
                'undergradStudents' => $profile->getStudentDetails()->getUndergradStudents(),
                'gradStudents' => $profile->getStudentDetails()->getGradStudents(),
                'otherStudents' => $profile->getStudentDetails()->getOtherStudents(),
                'fullTimeStudents' => $profile->getStudentDetails()->getFullTimeStudents(),
                'inStateStudents' => $profile->getStudentDetails()->getInStateStudents(),
                'outOfStateStudents' => $profile->getStudentDetails()->getOutOfStateStudents(),
                'partTimeStudents' => $profile->getStudentDetails()->getPartTimeStudents(),
                'interNationalStudents' => $profile->getStudentDetails()->getInterNationalStudents(),
            ],
            'facultyDetails'=> [
                'term' => $profile->getFacultyDetails()->getTerm(),
                'year' => $profile->getFacultyDetails()->getYear(),
                'fullTimeFaculty' => $profile->getFacultyDetails()->getFullTimeFaculty(),
                'studentFacultyRatio' => $profile->getFacultyDetails()->getStudentFacultyRatio(),
                'facultyHigherDegree' => $profile->getFacultyDetails()->getFacultyHigherDegree(),
                'avgUGClassSize' => $profile->getFacultyDetails()->getAvgUGClassSize()
            ],
            'academicDetails'=> [
                'term' => $profile->getAcademicDetails()->getTerm(),
                'year' => $profile->getAcademicDetails()->getYear(),
                'fullTimeFaculty' => $profile->getAcademicDetails()->getFullTimeFaculty(),
                'studentFacultyRatio' => $profile->getAcademicDetails()->getStudentFacultyRatio(),
                'facultyHigherDegree' => $profile->getAcademicDetails()->getFacultyHigherDegree(),
                'avgUGClassSize' => $profile->getAcademicDetails()->getAvgUGClassSize()
            ],
        ]);

    }
}
