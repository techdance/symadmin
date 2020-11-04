<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Entity\Group;
use App\Entity\InstitutionProfile;
use App\Entity\InstitutionLocationInfo;
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



    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $username         = $request->request->get("institutionEmail");
        $password         = $request->request->get("password");
        $user =  $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findOneByEmail($username);
  
        if (!$user) {
            //throw $this->createNotFoundException();
            return $this->respondWithSuccess(sprintf('Invalid User name'));
        }
        $isValid = $passwordEncoder->isPasswordValid($user, $password);

        if (!$isValid) {
            //throw new BadCredentialsException();
            return $this->respondWithSuccess(sprintf('Incorrect username or password'));
        }

        $result = $this->serializeUsers($user);

        // 'user' => base64_encode(rand(1000000000,9999999999).$request->request->get("institutionEmail")),
        // 	   'status' => true
        return $this->json([
            'user' => base64_encode(rand(1000000000, 9999999999) . $result["userName"]),
            'status' => true
        ]);
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
            'password' => $usr->getDummyPassword()
            //I have tried using getter method to retrieve image value here but I cannot because image is related to users
        );
    }


    /**
     * @Route("/getUserDetails", name="api_getUserDetails", methods={"GET"})
     */
    public function getUserDetails(Request $request)
    {
        $username  = substr(base64_decode($request->query->get("user")), 10);
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByUsername($username);
        if ($user) {
            $result = $this->serializeUsers($user);
            return $this->json([
                'user' => $result
            ]);
        }
        return $this->respondWithSuccess(sprintf('User %s is not available', $username));
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
