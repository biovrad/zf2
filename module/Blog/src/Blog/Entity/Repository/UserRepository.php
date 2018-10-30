<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use Zend\Authentication\AuthenticationService

class UserRepository extends EntityRepository{

    public function Login(\Blog\Entity\User $user, $sm){

        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($user->getUsrName());
        $adapter->setCredentialValue($user->getUsrPassword());
        $authResult = $authService->authenticate();
        $identity = null;

        if($authResult->isValid()){
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }

        return $authResult;
    }
}