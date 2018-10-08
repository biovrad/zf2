<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;

use Blog\Entity\Article;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Paginator\Paginator;
use Admin\Form\ArticleAddForm;

class ArticleController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')->from('Blog\Entity\Article', 'a')->orderBy('a.id', 'DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));

        return ['articles' => $paginator];
    }

    public function addAction(){

        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);

        $request = $this->getRequest();

        if($request->isPost()){
            $status = $message = '';
            $data = $request->getPost();
            $article = new Article();
            $form->setHydrator(new DoctrineHydrator($em, '\Article'));
            $form->bind($article);
            $form->setData($data);

            if($form->isValid()){
                $em->persist($article);
                $em->flush();

                $status = 'success';
                $message = 'Статья добавленна';
            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors){
                    foreach ($errors->getMessages() as $error){
                        $message .= ' ' . $error;
                    }
                }
            }
        } else {
            return ['form' =>$form];
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }
}
