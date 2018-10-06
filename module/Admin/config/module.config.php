<?php

return [
    'controllers' => [
        'invokables' => [
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController',
            'article' => 'Admin\Controller\ArticleController'
        ],
    ],

    'router' => [

        'routes' => [
            'admin' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/admin/',
                    'defaults' => [
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ],
                ],

                'may_terminate' => true,

                'child_routes' => [
                    'category' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'category/[:action/][:id/]',
                            'defaults' => [
                                'controller' => 'category',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'article' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'article/[:action/][:id/]',
                            'defaults' => [
                                'controller' => 'article',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
