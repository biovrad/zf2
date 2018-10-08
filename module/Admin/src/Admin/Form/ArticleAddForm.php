<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Admin\Filter\ArticleAddInputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHidrator;
use Blog\Entity\Article;

class ArticleAddForm extends Form implements ObjectManagerAwareInterface{

    protected  $objectManager;
    public function setObjectManager(ObjectManager $objectManager){
        $this->objectManager = $objectManager;
    }


    public function getObjectManager(){
        return $this->objectManager;
    }

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('articleAddForm');
        $this->setObjectManager($objectManager);
        $this->createElements();
    }

    public function createElements(){

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->setInputFilter(new ArticleAddInputFilter());

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'category',
            'options' => [
                'label' => 'Категория',
                'empty_option' => 'Выберете категорию ',
                'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Blog\Entity\Category',
                'property'       => 'categoryName',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',

            ]
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Заголовок',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',

            ]
        ]);

        $this->add([
            'name' => 'shortArticle',
            'type' => 'Textarea',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Начало статьи',
            ],
            'attributes' => [
                'class' => 'form-control ckeditor',
            ]
        ]);

        $this->add([
            'name' => 'article',
            'type' => 'Textarea',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Статья',
            ],
            'attributes' => [
                'class' => 'form-control ckeditor',
                'required' => 'required',
            ]
        ]);

        $this->add([
            'name' => 'isPublic',
            'type' => 'Checkbox',
            'options' => [
                'label' => 'Опубликовать',
                'use_hidden_Element' => true,
                'checked_value'   => 1,
                'unchecked_value' => 0,
            ],
            'attributes' => [
                'class' => 'form-control ckeditor',
                'required' => 'required',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Сохранить',
                'id' => 'bnt_submit',
                'class' => 'bnt bnt-primary',
            ]
        ]);


    }
}