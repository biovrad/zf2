<?php

namespace AuthDoctrine\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Blog\Entity\User;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;



class IndexController extends BaseController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $user = $em->getRepository('Blog\Entity\User')->findAll();

        return ['users' => $user];
    }

}