<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Group;
use App\Entity\Settings;
use App\Entity\User;
use App\Form\SettingsType;
use App\Form\UserType;
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
use Symfony\Component\HttpFoundation\JsonResponse;

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
                $ssoLoginFile = $request->files->get('ssoLogin');
                $collaboratedDirectLoginFile = $request->files->get('collaboratedDirectLogin');
                $sideNavigationMenuFile = $request->files->get('sideNavigationMenu');
                $sideNavigationMenuCollapsedFile = $request->files->get('sideNavigationMenuCollapsed');
                $loginLogoFileName = "";
                $dashboardLogoFileName = "";
                $ssoLoginFileName = "";
                $collaboratedDirectLoginFileName = "";
                $sideNavigationMenuFileName = "";
                $sideNavigationMenuCollapsedFileName = "";
                
      
                if ($loginLogoFile) {
                    $loginLogoFileName = md5(uniqid()) . '.' . $loginLogoFile->guessExtension();
                }

                if ($dashboardLogoFile) {
                    $dashboardLogoFileName = md5(uniqid()) . '.' . $dashboardLogoFile->guessExtension();
                }

                if ($ssoLoginFile) {
                    $ssoLoginFileName = md5(uniqid()) . '.' . $ssoLoginFile->guessExtension();
                }

                if ($collaboratedDirectLoginFile) {
                    $collaboratedDirectLoginFileName = md5(uniqid()) . '.' . $collaboratedDirectLoginFile->guessExtension();
                }

                if ($sideNavigationMenuFile) {
                    $sideNavigationMenuFileName = md5(uniqid()) . '.' . $sideNavigationMenuFile->guessExtension();
                }

                if ($sideNavigationMenuCollapsedFile) {
                    $sideNavigationMenuCollapsedFileName = md5(uniqid()) . '.' . $sideNavigationMenuCollapsedFile->guessExtension();
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

                if ($setting && $ssoLoginFile) {
                    if ($exstingSettings && $exstingSettings->getSsoLogin()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getSsoLogin();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getSsoLogin()) {
                        $setting->setSsoLogin($exstingSettings->getSsoLogin());
                    }
                }


                if ($setting && $collaboratedDirectLoginFile) {
                    if ($exstingSettings && $exstingSettings->getCollaboratedDirectLogin()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getCollaboratedDirectLogin();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getCollaboratedDirectLogin()) {
                        $setting->setCollaboratedDirectLogin($exstingSettings->getCollaboratedDirectLogin());
                    }
                }

                
                if ($setting && $sideNavigationMenuFile) {
                    if ($exstingSettings && $exstingSettings->getSideNavigationMenu()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getSideNavigationMenu();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getSideNavigationMenu()) {
                        $setting->setSideNavigationMenu($exstingSettings->getSideNavigationMenu());
                    }
                }


                if ($setting && $sideNavigationMenuCollapsedFile) {
                    if ($exstingSettings && $exstingSettings->getSideNavigationMenuCollapsed()) {
                        $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $exstingSettings->getSideNavigationMenuCollapsed();

                        if (file_exists($file_to_delete)) {
                            unlink($file_to_delete);
                        }
                    }
                } else {

                    if ($exstingSettings && $exstingSettings->getSideNavigationMenuCollapsed()) {
                        $setting->setSideNavigationMenuCollapsed($exstingSettings->getSideNavigationMenuCollapsed());
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


                if ($ssoLoginFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $ssoLoginFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $ssoLoginFileName
                        );

                        $setting->setSsoLogin("uploads/settings/logo/" . $ssoLoginFileName);
                    } catch (FileException $e) {
                        //Handle error
                    }
                }

                if ($collaboratedDirectLoginFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $collaboratedDirectLoginFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $collaboratedDirectLoginFileName
                        );

                        $setting->setCollaboratedDirectLogin("uploads/settings/logo/" . $collaboratedDirectLoginFileName);
                    } catch (FileException $e) {
                        //Handle error
                    }
                }


                if ($sideNavigationMenuFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $sideNavigationMenuFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $sideNavigationMenuFileName
                        );

                        $setting->setSideNavigationMenu("uploads/settings/logo/" . $sideNavigationMenuFileName);
                    } catch (FileException $e) {
                        //Handle error
                    }
                }


                if ($sideNavigationMenuCollapsedFile) {
                    // Move the file to the directory where your form images are stored
                    try {
                        $sideNavigationMenuCollapsedFile->move(
                            $this->paramBag->get('upload_directory') . "/settings/logo/",
                            $sideNavigationMenuCollapsedFileName
                        );

                        $setting->setsideNavigationMenuCollapsed("uploads/settings/logo/" . $sideNavigationMenuCollapsedFileName);
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
	
	/**	
	 * @Route("/api/image-get-logos", name="api-image-get-logos")
	 
     */
   

    public function getImages(Request $request)
    {

    $responseData = [];

    $em = $this->getDoctrine()->getManager();

    $get_all_images = $em->getRepository(Settings::class)->find(1);

    $protocal = 'http://';
    if($request->isSecure()){
        $protocal = 'https://';
    }
    $responseData = [
    'login_logo' => $protocal .$request->server->get('HTTP_HOST') . "/".$get_all_images->getLoginLogo(),
    'sso_login_logo' => $protocal .$request->server->get('HTTP_HOST') . "/".$get_all_images->getSsoLogin(),
    'collaborated_direct_login_logo' => $protocal .$request->server->get('HTTP_HOST') . "/".$get_all_images->getCollaboratedDirectLogin(),
    'side_navigation_menu_logo' => $protocal .$request->server->get('HTTP_HOST') . "/".$get_all_images->getSideNavigationMenu(),
    'side_navigation_menu_collapsed_logo' => $protocal .$request->server->get('HTTP_HOST') . "/".$get_all_images->getSideNavigationMenuCollapsed()
    ];

    $response = new JsonResponse();

    $response->setData($responseData);

    return $response;
    }
}
