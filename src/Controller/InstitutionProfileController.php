<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Form;
use App\Entity\Group;
use App\Entity\GroupHasEntity;
use App\Entity\User;
use App\Entity\FormValue;
use App\Entity\InstitutionProfile;
use App\Form\FormType;
use App\Form\Type\InstitutionProfileType;
use App\Form\Type\UserType;
use App\Model\RoleModel;
use App\Service\FileUploader;
use Doctrine\DBAL\Types\DateType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InstitutionProfileController extends EasyAdminController
{

    private $paramBag;

    public function __construct(ParameterBagInterface $params)
    {
        $this->paramBag = $params;
    }

    /**
     * @Route("/institution-profile", name="institution_profile")
     */
    public function institutionProfile(Request $request, FileUploader $fileUploader)
    {
        
        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository(InstitutionProfile::class)->find(1);
        
        $existingProfile = '';

        if (is_null($profile)) {
             $profile = new InstitutionProfile();
        } else {
            $existingProfile = clone $profile;
        }
        
        $form = $this->createForm(InstitutionProfileType::class, $profile);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
           
                $file = $form['insProfileImage']->getData();


                if ( $file) {
                    $newFilename = md5(uniqid()).'.'.$file->guessExtension();
                }


                if ($profile && $file) {
    
                    if ($existingProfile && $existingProfile->getInsProfileImage()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir(). '/public/' . $existingProfile->getInsProfileImage();
                    
                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                }

        
                if ( $file) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $file->move(
                            $this->paramBag->get('upload_directory')."/admin/profile/",
                            $newFilename
                        );
                    } catch (FileException $e) {
                        //Handle error
                    }
                }

                if ( $file) {
                    $profile->setInsProfileImage("uploads/admin/profile/" . $newFilename);
                }

                $em->persist($profile);
                $em->flush();

                $this->addFlash(
                    'success',
                    "Institution Profile Saved Successfully"
                );

                return $this->redirect($this->generateUrl('institution_profile'));
            } else {
               dump($form->getErrors());die;
            }
        }

        return $this->render('admin/profile/profile.html.twig', [
               'form' => $form->createView()
        ]);
    }

   
}
