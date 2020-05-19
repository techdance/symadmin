<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Model\RoleModel;
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
        $prefix = $request->request->get("prefix");
        $firstName = $request->request->get("firstName");
        $lastName = $request->request->get("lastName");
        $institutionEmail = $request->request->get("institutionEmail");
        $institutionName = $request->request->get("institutionName");
        $password = $request->request->get("password");

        $errors = [];
        if (strlen($password) < 6) {
            $errors[] = "Password should be at least 6 characters.";
        }
        if (!$errors) {
            // $data = json_decode($request->getContent(), true);
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user->setEmail($institutionEmail);
            $user->setPassword($encodedPassword);
            //$user->setPassword($encodedPassword);
            $user->setPrefix($prefix);
            $user->setFirstName($firstName);
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
                return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
                // return $this->json([
                //   	   'user' => $user
                //  		]);

            } catch (UniqueConstraintViolationException $e) {
                $errors[] = "The email provided already has an account!";
            } catch (\Exception $e) {
                $errors[] = "Unable to save new user at this time.";
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
        $institutionEmail         = $request->request->get("institutionEmail");
        $password         = $request->request->get("password");
        $user =  $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByEmail($institutionEmail);
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
            'user' => base64_encode(rand(1000000000, 9999999999) . $result["institutionEmail"]),
            'status' => true
        ]);
    }

    private function serializeUsers(User $usr)
    {
        return array(
            'institutionEmail' => $usr->getEmail(),
            'prefix' => $usr->getPrefix(),
            'firstName' => $usr->getFirstname(),
            'lastName' => $usr->getLastname(),
            'institutionName' => $usr->getInstitutionName(),
            'roles' => $usr->getRoles()
            //I have tried using getter method to retrieve image value here but I cannot because image is related to users
        );
    }


    /**
     * @Route("/getUserDetails", name="api_getUserDetails", methods={"GET"})
     */
    public function getUserDetails(Request $request)
    {
        $institutionEmail         = substr(base64_decode($request->query->get("user")), 10);
        $user = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($institutionEmail);
        if ($user) {
            $result = $this->serializeUsers($user);
            return $this->json([
                'user' => $result
            ]);
        }
        return $this->respondWithSuccess(sprintf('User %s is not available', $institutionEmail));
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
}
