<?php
namespace App\Util;

use App\Entity\Group;
use App\Model\RoleModel;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\UserManipulator as manipulator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Executes some manipulations on the users.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class UserManipulator extends manipulator
{
    /**
     * User manager.
     *
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * UserManipulator constructor.
     *
     * @param UserManagerInterface     $userManager
     * @param EventDispatcherInterface $dispatcher
     * @param RequestStack             $requestStack
     */
    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $dispatcher, RequestStack $requestStack, ContainerInterface $container)
    {
        $this->userManager = $userManager;
        $this->dispatcher = $dispatcher;
        $this->requestStack = $requestStack;
        $this->container = $container;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param bool   $active
     * @param bool   $superadmin
     *
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $password, $email, $active, $superadmin)
    {   
        $this->userManager = $this->container->get('fos_user.user_manager');
        $user = $this->userManager->createUser();
        $user->setPrefix('Mr. ');
        $user->setFirstName($username);
        $user->setLastName($username);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((bool) $active);
        $user->setSuperAdmin((bool) $superadmin);
        $user->setEmailCanonical($email);
        $user->setInstitutionName($username);
        

        $entityManger = $this->container->get('doctrine');
       
        if (count($user->getRoles())) {
            foreach($user->getRoles() as $role) {
                 $defaultUserRole = $entityManger->getRepository(Group::class)->findOneBy([
                    'name' => $role
                ]);

                if(!is_null($defaultUserRole)) {
                    $user->addGroup($defaultUserRole);
                }
            }
        }
      
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_CREATED, $event);

        return $user;
    }

    /**
     * Activates the given user.
     *
     * @param string $username
     */
    public function activate($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_ACTIVATED, $event);
    }

    /**
     * Deactivates the given user.
     *
     * @param string $username
     */
    public function deactivate($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setEnabled(false);
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_DEACTIVATED, $event);
    }

    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setPlainPassword($password);
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_PASSWORD_CHANGED, $event);
    }

    /**
     * Promotes the given user.
     *
     * @param string $username
     */
    public function promote($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setSuperAdmin(true);

       
        // $entityManger = $this->container->get('doctrine');
        // $defaultUserRole = $entityManger->getRepository(Group::class)->findOneBy([
        //     'name' => 'ROLE_ADMIN'
        // ]);

        // if(!is_null($defaultUserRole)) {
        //     $user->addGroup($defaultUserRole);
        // }
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_PROMOTED, $event);
    }

    /**
     * Demotes the given user.
     *
     * @param string $username
     */
    public function demote($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setSuperAdmin(false);

        
         
        $entityManger = $this->container->get('doctrine');
        $defaultUserRole = $entityManger->getRepository(Group::class)->findOneBy([
            'name' => RoleModel::ROLE_SUPER_ADMIN
        ]);

        if(!is_null($defaultUserRole)) {
            $user->removeGroup($defaultUserRole);
        }

        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->getRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_DEMOTED, $event);
    }

    /**
     * Adds role to the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was added, false if user already had the role
     */
    public function addRole($username, $role)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        if ($user->hasRole($role)) {
            return false;
        }
        
        $user->addRole($role);

        $user = $this->addRoleGroup($user, $role);
        
        $this->userManager->updateUser($user);

        return true;
    }

    /**
     * Removes role from the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was removed, false if user didn't have the role
     */
    public function removeRole($username, $role)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        if (!$user->hasRole($role)) {
            return false;
        }
        $user->removeRole($role);
        
        $user = $this->removeRoleGroup($user, $role);

        $this->userManager->updateUser($user);

        return true;
    }

    private function addRoleGroup($user, $role)
    {
        $entityManger = $this->container->get('doctrine');
        $defaultUserRole = $entityManger->getRepository(Group::class)->findOneBy([
            'name' => $role
        ]);

        if(!is_null($defaultUserRole)) {
            $user->addGroup($defaultUserRole);
        }

        return $user;
    }

    private function removeRoleGroup($user, $role)
    {
        $entityManger = $this->container->get('doctrine');
        $defaultUserRole = $entityManger->getRepository(Group::class)->findOneBy([
            'name' => $role
        ]);

        if(!is_null($defaultUserRole)) {
            $user->removeGroup($defaultUserRole);
        }

        return $user;
    }

    /**
     * Finds a user by his username and throws an exception if we can't find it.
     *
     * @param string $username
     *
     * @throws \InvalidArgumentException When user does not exist
     *
     * @return UserInterface
     */
    private function findUserByUsernameOrThrowException($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }

        return $user;
    }

    /**
     * @return Request
     */
    private function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }
}
