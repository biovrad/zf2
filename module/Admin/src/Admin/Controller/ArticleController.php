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

    public function editAction(){

        $status = $message = '';
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);
        $id = (int) $this->params()->fromRoute('id', 0);
        $article = $em->find('Blog\Entity\Article', $id);

        if(empty($article)){
            $message = 'Статья не найденна';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/edit');

        }

        $form->setHydrator(new DoctrineHydrator($em, '\Article'));
        $form->bind($article);

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();
            $form->setData($data);

            if($form->isValid()){
                $em->persist($article);
                $em->flush();

                $status = 'success';
                $message = 'Статья измененна';
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
            return ['form' =>$form, 'id' => $id];
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Статья удаленна';

        try{
            $repository = $em->getRepository('Blog\Entity\Article');
            $article = $repository->find($id);
            $em->remove($article);
            $em->flush();
        } catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления статьи:' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/article');
    }
}
