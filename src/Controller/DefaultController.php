<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('easyadmin');
    }
}