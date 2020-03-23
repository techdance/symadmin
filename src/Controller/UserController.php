<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpClient\HttpClient;

class UserController extends AbstractController
{
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
	 * @Route("/register", name="api_register", methods={"POST"}, schemes={"https"})
	 */
	public function register(UserPasswordEncoderInterface $passwordEncoder, Request $request)
	{

		$user = new User();

	   	$prefix                  = $request->request->get("prefix");
	   	$firstName               = $request->request->get("firstName");
	   	$lastName			     = $request->request->get("lastName");
	   	$institutionEmail        = $request->request->get("institutionEmail");
	   	$institutionName         = $request->request->get("institutionName");
	   	$password			     = $request->request->get("password");

		$errors = [];
		if(strlen($password) < 6)
		{
		   $errors[] = "Password should be at least 6 characters.";
		}
		$data1 = '{
	       "/collaborated.commonwebsserviceapi/create-user":{
	          "prefix": "'.$prefix.'",
	          "firstName": "'.$firstName.'",
	          "lastName": "'.$lastName.'",
	          "institutionEmail": "'.$institutionEmail.'",
	          "institutionName":"'.$institutionName.'",
	          "password": "'.$password.'"
	         }
	     }';
	     /*print_r($data1);
	     $httpClient = HttpClient::create();
		   $response = $httpClient->request('POST', 'http://13.88.11.67:8080/api/jsonws/invoke', [
		           'body' => $data1
		   ]);
		 $status = $response->getContent();
		  if($status !=''){
		   	$user->setReferenceId("12346");
		   }else {
		   	$errors[] = "External DB not stored.";
		  }*/		
		if(!$errors)
		{
			// $data = json_decode($request->getContent(), true);
		   	$encodedPassword = $passwordEncoder->encodePassword($user, $password);
		   	$user->setInstitutionEmail($institutionEmail);
		   	$user->setPassword($encodedPassword);
		   	$user->setPassword($encodedPassword);
		   	$user->setPrefix($prefix);
		   	$user->setFirstName($firstName);
		   	$user->setLastName($lastName);
		   	$user->setInstitutionName($institutionName);
			$user->setReferenceId("12346");
			$em = $this->getDoctrine()->getManager();
			try
			{
		        $em->persist($user);
		        $em->flush();
				return $this->json([
		    	   'user' => $user
		   		]);
			}
			catch(UniqueConstraintViolationException $e)
			{
			   $errors[] = "The email provided already has an account!";
			}
			catch(\Exception $e)
			{
			   $errors[] = "Unable to save new user at this time.";
			}
		}
	   	return $this->json([
			   'errors' => $errors
		   ], 400);
	}

	/**
	 * @Route("/login", name="api_login", methods={"POST"})
	 */
	public function login()
	{
	  // return $this->json(['result' => true]);
	}
	/**
	 * @Route("/profile", name="api_profile")
	 */
	public function profile()
	{
	   return $this->json([
		   'user' => $this->getUser()
	   ]);
	}
	

	/**
	 * @Route("/", name="api_home")
	 */
	public function home()
	{
	   return $this->json(['result' => true]);
	}
}
