<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginAuthenticator extends AbstractGuardAuthenticator
{

   private $passwordEncoder;
   private $login_user_id;
   public function __construct(UserPasswordEncoderInterface $passwordEncoder)
   {
       $this->passwordEncoder = $passwordEncoder;
   }

   public function supports(Request $request)
   {
       return $request->get("_route") === "api_login" && $request->isMethod("POST");
   }

   public function getCredentials(Request $request)
   {
       return [
           'institutionEmail' => $request->request->get("institutionEmail"),
           'password' => $request->request->get("password")
       ];
   }

   public function getUser($credentials, UserProviderInterface $userProvider)
   {
       return $userProvider->loadUserByUsername($credentials['institutionEmail']);
   }

   public function checkCredentials($credentials, UserInterface $user)
   {
	//	$this->login_user_id = $user->getReferenceId()
//		var_dump($this->login_user_id);die();
       return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
   }

   public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
   {
       return new JsonResponse([
           'error' => $exception->getMessageKey()
       ], 400);
   }

   public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
   {
       return new JsonResponse([
           'user' => base64_encode(rand(1000000000,9999999999).$request->request->get("institutionEmail")),
     	   'status' => true
       ]);
   }

   public function start(Request $request, AuthenticationException $authException = null)
   {
       return new JsonResponse([
           'error' => 'Access Denied'
       ]);
   }

   public function supportsRememberMe()
   {
       return false;
   }

//   public function createAuthenticatedToken(UserInterface $user, $providerKey)
//   {
//
//   }
}
