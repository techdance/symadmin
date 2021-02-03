<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
		$protocal = 'http://';
        if($request->isSecure()){
        	$protocal = 'https://';
        }
        $url = $protocal .$request->server->get('HTTP_HOST') .":3000";
        return $this->redirect($url, 301);
    }
}
