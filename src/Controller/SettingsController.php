<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\Settings;
use App\Entity\User;
use App\Form\Type\SettingsType;
use App\Form\Type\UserType;
use App\Manager\UserManager;
use App\Model\RoleModel;
use Doctrine\DBAL\Types\DateType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SettingsController extends EasyAdminController
{
    private $passwordEncoder;

    private $userManager;

    private $paramBag;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserManager $userManager,ParameterBagInterface $params)
    {
        $this->passwordEncoder = $passwordEncoder;

        $this->userManager = $userManager;

        $this->paramBag = $params;
    }

    /**
     * @Route("/image-settings", name="image_settings")
     */
    public function saveImageSetting(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $setting = $em->getRepository(Settings::class)->find(1);

        $exstingSettings = '';

        if (is_null($setting)) {
            $setting = new Settings();
        } else {
            $exstingSettings = clone $setting;
        }

        

       

        $form = $this->createForm(SettingsType::class, $setting);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $loginLogoFile = $request->files->get('loginLogo');
                $dashboardLogoFile = $request->files->get('dashboardLogo');
                $loginLogoFileName = "";
                $dashboardLogoFileName = "";
                
      
                if ($loginLogoFile) {
                    $loginLogoFileName = md5(uniqid()) . '.' . $loginLogoFile->guessExtension();
                }

                if ($dashboardLogoFile) {
                    $dashboardLogoFileName = md5(uniqid()) . '.' . $dashboardLogoFile->guessExtension();
                }

               




                if ($setting && $loginLogoFile) {
                    if ($exstingSettings && $exstingSettings->getLoginLogo()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getLoginLogo();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getLoginLogo()) {
                        $setting->setLoginLogo($exstingSettings->getLoginLogo());
                    }
                }

                if ($setting && $dashboardLogoFile) {
                    if ($exstingSettings && $exstingSettings->getAdminDashboardLogo()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getAdminDashboardLogo();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getAdminDashboardLogo()) {
                        $setting->setAdminDashboardLogo($exstingSettings->getAdminDashboardLogo());
                    }
                }

                if ($loginLogoFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $loginLogoFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $loginLogoFileName
                        );
                        $setting->setLoginLogo("uploads/settings/logo/" . $loginLogoFileName);
                    } catch (FileException $e) {
                        //Handle error
                    }
                }

                if ($dashboardLogoFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $dashboardLogoFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $dashboardLogoFileName
                        );

                        $setting->setAdminDashboardLogo("uploads/settings/logo/" . $dashboardLogoFileName);
                    } catch (FileException $e) {
                        //Handle error
                    }
                }


                $em->persist($setting);
                $em->flush();

                $this->addFlash(
                    'success',
                    "Image Settings Added Successfully"
                );

                return $this->redirect($this->generateUrl('image_settings'));
            }else {
               dump($form->getErrors());die;
            }
        }




        return $this->render('admin/settings/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
