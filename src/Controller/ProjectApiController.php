<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Entity\Group;
use App\Entity\InstitutionProfile;
use App\Entity\Master\FosUser;
use App\Entity\Master\MasterLanguage;
use App\Entity\Master\CommunicationPreferences;
use App\Entity\Master\CollaboratedProfileAreaofInterest;
use App\Entity\Master\Collaboratedlabscreenprojectoverview;
use App\Entity\Master\CollaboratedProjectInvitetracking;
use App\Entity\Master\Collaborateduserprofessionalbio;
use App\Entity\Master\Collaboratedusercredential;
use App\Entity\Master\CollaboratedLanguagePreferences;
use App\Entity\Master\CollaboratedLabScreenProjectPartners;
use App\Entity\Master\MasterInstitutionLocationInfo;
use App\Entity\Master\CollaboratedUserProfileimage;
use App\Entity\Master\Collaboratedlabdetailedcoursehours;
use App\Entity\Master\Collaboratedlabdetailedcourseidentification;
use App\Entity\Master\Collaboratedlabdetailedcourseresources;
use App\Entity\Master\Collaboratedlabdetailedinstructorqualification;
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


class ProjectApiController extends AbstractController
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
     * @Route("/projectApi", name="project_api", schemes={"https"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

 
    /**
     * @Route("/api/CollaboratedlabscreenprojectoverviewSave", name="api_Colla_lab_projectoverview_Save", methods={"POST"})
     */
    public function CollaboratedlabscreenprojectoverviewSave(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token  = $request->query->get("token");
        $createDate  = $request->query->get("createDate");
        $modifiedDate  = $request->query->get("modifiedDate");
        $projectOwnedId  = $request->query->get("projectOwnedId");
        $projectDescription  = $request->query->get("projectDescription");
        $projectName  = $request->query->get("projectName");
        $projectType  = $request->query->get("projectType");
        $projectDiscipline1  = $request->query->get("projectDiscipline1");
        $projectDiscipline2  = $request->query->get("projectDiscipline2");
        $projectDiscipline3  = $request->query->get("projectDiscipline3");
        $role  = $request->query->get("role");
        $projectStartDate  = $request->query->get("projectStartDate");
        $projectEndDate  = $request->query->get("projectEndDate");
        $projectDocumentId  = $request->query->get("projectDocumentId");
        $percentage  = $request->query->get("percentage");
        $interestId  = $request->query->get("interestId");
        $projectStatus  = $request->query->get("projectStatus");

        if(empty($token)){
            $token  = $request->request->get("token");
            $createDate  = $request->request->get("createDate");
            $modifiedDate  = $request->request->get("modifiedDate");
            $projectOwnedId  = $request->request->get("projectOwnedId");
            $projectDescription  = $request->request->get("projectDescription");
            $projectName  = $request->request->get("projectName");
            $projectType  = $request->request->get("projectType");
            $projectDiscipline1  = $request->request->get("projectDiscipline1");
            $projectDiscipline2  = $request->request->get("projectDiscipline2");
            $projectDiscipline3  = $request->request->get("projectDiscipline3");
            $role  = $request->request->get("role");
            $projectStartDate  = $request->request->get("projectStartDate");
            $projectEndDate  = $request->request->get("projectEndDate");
            $projectDocumentId  = $request->request->get("projectDocumentId");
            $percentage  = $request->request->get("percentage");
            $interestId  = $request->request->get("interestId");
            $projectStatus  = $request->request->get("projectStatus");
        }

        $createDate = new DateTime($createDate);
        $modifiedDate = new DateTime($modifiedDate);
        $projectStartDate = new DateTime($projectStartDate);
        $projectEndDate = new DateTime($projectEndDate);

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
      
        $Collaboratedlabscreenprojectoverview = $this->getDoctrine()->getRepository(Collaboratedlabscreenprojectoverview::class)->findOneBy([
            'interestId' => $interestId
        ]);

        if(empty($Collaboratedlabscreenprojectoverview)){
            $Collaboratedlabscreenprojectoverview = new Collaboratedlabscreenprojectoverview();
        } 

        $CollaboratedProfileAreaofInterest = $this->getDoctrine()->getRepository(CollaboratedProfileAreaofInterest::class)->findOneById($interestId);


            $Collaboratedlabscreenprojectoverview->setUserId($Muser);
            $Collaboratedlabscreenprojectoverview->setCreateDate($createDate);
            $Collaboratedlabscreenprojectoverview->setModifiedDate($modifiedDate);
            $Collaboratedlabscreenprojectoverview->setProjectOwnedId($projectOwnedId);
            $Collaboratedlabscreenprojectoverview->setProjectDescription($projectDescription);
            $Collaboratedlabscreenprojectoverview->setProjectName($projectName);
            $Collaboratedlabscreenprojectoverview->setProjectType($projectType);
            $Collaboratedlabscreenprojectoverview->setProjectDiscipline1($projectDiscipline1);
            $Collaboratedlabscreenprojectoverview->setProjectDiscipline2($projectDiscipline2);
            $Collaboratedlabscreenprojectoverview->setProjectDiscipline3($projectDiscipline3);
            $Collaboratedlabscreenprojectoverview->setRole($role);
            $Collaboratedlabscreenprojectoverview->setProjectStartDate($projectStartDate);
            $Collaboratedlabscreenprojectoverview->setProjectEndDate($projectEndDate);
            $Collaboratedlabscreenprojectoverview->setProjectDocumentId($projectDocumentId);
            $Collaboratedlabscreenprojectoverview->setPercentage($percentage);
            $Collaboratedlabscreenprojectoverview->setProjectStatus($projectStatus);
            $Collaboratedlabscreenprojectoverview->setInterestId($CollaboratedProfileAreaofInterest);
            $em->persist($Collaboratedlabscreenprojectoverview);
            $em->flush();

            return $this->json([
                'message'=>'Collaborated project overview saved successfully',
                'status' => true
            ]);            

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

  
}
