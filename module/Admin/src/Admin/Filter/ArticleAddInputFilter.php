<?php

namespace Admin\Filter;

use Zend\InputFilter\InputFilter;

class ArticleAddInputFilter extends InputFilter{

    public function __construct(){

        $this->add([
            'name' => 'title',
            'required' => true,
            'validator' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
            ],
            'filter' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ]
        ]);

        $this->add([
            'name' => 'shortArticle',
            'required' => false,
            'validator' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 800,
                    ],
                ],
            ],
            'filter' => [
                ['name' => 'StringTrim'],
            ]
        ]);

        $this->add([
            'name' => 'article',
            'required' => true,
            'filter' => [
                ['name' => 'StringTrim'],
            ]
        ]);

        $this->add([
            'name' => 'isPublic',
            'required' => false,
        ]);

        $this->add([
            'name' => 'category',
            'required' => true,
        ]);
    }
}
