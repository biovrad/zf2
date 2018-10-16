<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class CommentController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')->from('Blog\Entity\Comment', 'a')->orderBy('a.id', 'DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));

        return ['comment' => $paginator];
    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Коментарий удален';

        try{
            $repository = $em->getRepository('Blog\Entity\Comment');
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush();
        } catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления коментария:' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/comment');
    }
}
