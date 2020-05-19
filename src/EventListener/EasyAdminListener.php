<?php 

namespace App\EventListener;

use App\Entity\User;
use App\Manager\RolePermissionManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Configuration\ConfigManager;
use EasyCorp\Bundle\EasyAdminBundle\Exception\NoPermissionException;

class EasyAdminListener 
{
    private $tokenStorage;

    private $rolePermissionManager;

    public function __construct(TokenStorageInterface $tokenStorage, RolePermissionManager $rolePermissionManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->rolePermissionManager = $rolePermissionManager;
    }

    /**
     * On kernel controller event
     *
     * @param ControllerEvent $event
     * @return void
     */
    public function onKernelController(ControllerEvent $event)
    {
        $request =  $event->getRequest();

        $action = $request->query->get('action', 'list');

        if (!$this->tokenStorage->getToken()) {
            return true;
        }
        
        if (!$this->tokenStorage->getToken()->getUser() instanceof User) {
            return true;
        }

        
        $id = $request->query->get('id');
        $entity = $request->query->get('entity');

        if (!$entity) {
            return true;
        }
       
        
        $rolePermissions = $this->rolePermissionManager->initRolePermissions()->getRolePermissions();


        
        if (!in_array(strtoupper($action), $rolePermissions)) {
            throw new NoPermissionException(['action' => $action, 'entity_name' => $entity, 'entity_id' => $id]);
        }

    }
}
