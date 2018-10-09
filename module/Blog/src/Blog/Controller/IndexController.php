<?php

namespace Blog\Controller;

use Application\Controller\BaseController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query
            ->add('select', 'a')
            ->add('from', 'Blog\Entity\Article a')
            ->add('where', 'a.isPublic=1')
            ->add('orderBy', 'a.id ASC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(2);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));

        return ['articles' => $paginator];
    }
}
