<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use Blog\Entity\Category;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM Blog\Entity\Category u ORDER BY u.id DESC');
        $rows = $query->getResult();

        return ['category' => $rows];
    }

    public function addAction(){

        $form = new CategoryAddForm;
        $status = $message = '';
        $em = $this->getEntityManager();
        $request = $this->getRequest();

        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){

                $category = new Category();
                $category->exchangeArray($form->getData());
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Категория добавленна';
            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        } else {
            return ['form' =>$form];
        }

        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function editAction(){

        $form = new CategoryAddForm;
        $status = $message = '';
        $em = $this->getEntityManager();
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = $em->find('Blog\Entity\Category', $id);

        if(empty($category)){
            $message = 'Категория не найденна';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/edit');

        }

        $form->bind($category);
        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();
            $form->setData($data);

            if($form->isValid()){
                $em->persist($category);
                $em->flush();

                $status = 'success';
                $message = 'Категория измененна';
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

        return $this->redirect()->toRoute('admin/category');

    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();

        $status = 'success';
        $message = 'Запись удаленна';

        try{
            $repository = $em->getRepository('Blog\Entity\Category');
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush();
        } catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления записи:' . $ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/category');
    }
}
