<?php
namespace App\Manager;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RolePermissionManager 
{
    protected $authorizationChecker;

    protected $tokenStorage;

    protected $rolePermissions;

    protected $request;
    
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, RequestStack $request)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->request = $request->getMasterRequest();
    }

    /**
     * Init role permissions
     *
     * @return self
     */
    public function initRolePermissions() : self
    {
        
        $user = $this->tokenStorage->getToken()->getUser();
        
        $this->getEntityPermissions($this->request->query->get('entity'));
       
        return $this;
    }


    public function getEntityPermissions(?string $entity)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $myPermissions = [];

        foreach ($user->getGroups() as $group) {
            if ($group->getEntities()) {
                foreach ($group->getEntities() as $entities) {
                    if ($entities->getEntities()->getName() == $entity) {
                        $entityRoles = $entities->getRoles();
                        if ($entityRoles) {
                            array_push($myPermissions, ...$entities->getRoles());
                        }
                    }
                }
            }
        }

        if ($entity === 'Enitygroup') {
            if (in_array('ROLE_DEVELOPER',  $user->getRoles())) { 
                return $myPermissions = [
                    'CAN_SHOW', 'CAN_EDIT', 'CAN_NEW', 'CAN_LIST'
                ];
            }
        }

        if (count($myPermissions) == 0) {
           
            if (in_array('ROLE_SUPER_ADMIN',  $user->getRoles())) {
                $myPermissions = [
                    'CAN_SHOW', 'CAN_EDIT', 'CAN_NEW', 'CAN_LIST', 'CAN_DELETE'
                ];
            }

             if (in_array('ROLE_DEVELOPER',  $user->getRoles())) {
                $myPermissions = [
                    'CAN_SHOW', 'CAN_EDIT', 'CAN_NEW', 'CAN_LIST', 'CAN_DELETE'
                ];
            }
        }

    
        if (in_array('CAN_SHOW', $myPermissions)) {
            $myPermissions[] = 'CAN_LIST';
            $myPermissions[] = 'CAN_SEARCH';
        }

        if (in_array('CAN_NEW', $myPermissions)) {
            $myPermissions[] = 'CAN_CREATE';
        }

        if (in_array('CAN_DELETE', $myPermissions)) {
            $myPermissions[] = 'CAN_BATCH';
        }

        return $this->rolePermissions = array_map(function($value) {
            return str_replace("CAN_", "", $value);
        }, $myPermissions);

    }

    /**
     * Get session user role permission
     *
     * @return array
     */
    public function getRolePermissions() : array
    {
        return $this->rolePermissions;
    }

    /**
     * Splice easy admin actions
     *
     * @param array $actions
     * @return array
     */
    public function spliceEasyAdminActions(array $actions) : array
    {
        foreach ($actions as $key => $action) {
            if (!in_array(strtoupper($key), $this->rolePermissions)) {
                unset($actions[$key]);
                continue;
            }
            $actions[$key]['roles'] =  $this->rolePermissions;
        }

       

        return $actions;
    }

    public function getUserRoles() 
    {
        return $this->tokenStorage->getToken()->getUser()->getRoles();
    }


}


