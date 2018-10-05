<?php

namespace Admin\Form;

use Zend\Form\Form;

class CategoryAddForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('categoryAddForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

//        $this->setInputFilter(new CategoryAddInputFilter());

        $this->add([
            'name' => 'categoryKey',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Ключ',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',

            ]
        ]);

        $this->add([
            'name' => 'categoryName',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Название',
            ],
            'attributes' => [
                'class' => 'form-control',
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