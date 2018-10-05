<?php

return [
    'controllers' => [
        'invokables' => [
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController'
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
