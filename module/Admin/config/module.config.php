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

    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'Admin\Lib\AdminNavigationFactory'
        ]
    ],

    'navigation' => [
        'default' => [
            [
                'label' => 'Главная',
                'route' => 'Home'
            ]
        ],
        'admin_navigation' => [
            [
                'label' => 'Панель управления',
                'route' => 'admin',
                'action' => 'index',
                'resource' => 'Admin\Controller\Index',

                'pages' => [
                    [
                        'label' => 'Статьи',
                        'route' => 'admin/article',
                        'action' => 'index',
                    ],
                    [
                        'label' => 'Добавить статью',
                        'route' => 'admin/article',
                        'action' => 'add',
                    ],
                    [
                        'label' => 'Категории',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ],
                    [
                        'label' => 'Добавить категорию',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ],
                ],
            ]
        ]

    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml'
        ]
    ],
];
