<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Registration;
use App\Form\RegistrationForm;
/**
 * registration controller.
 * @Route("/api", name="api_")
 */
class RegistrationController extends FOSRestController
{
  /**
   * Lists all registrations.
   * @Rest\Get("/registrations")
   *
   * @return Response
   */
  public function getRegistrationAction()
  {
    $repository = $this->getDoctrine()->getRepository(Registration::class);
    $registrations = $repository->findall();
    return $this->handleView($this->view($registrations));
  }
  /**
   * Create registration.
   * @Rest\Post("/registration")
   *
   * @return Response
   */
  public function postRegistrationAction(Request $request)
  {
    $registration = new Registration();
    $form = $this->createForm(RegistrationForm::class, $registration);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($registration);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
}