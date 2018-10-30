<?php

namespace AuthDoctrine;

return [
    'controllers' => [
        'invokables' => [
            'AuthDoctrine\Controller\Index' => 'AuthDoctrine\Controller\IndexController',
        ],
    ],

    'router' => [

        'routes' => [
            'auth-doctrine' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/auth-doctrine/',
                    'defaults' => [
                        '__NAMESPACE__' => 'AuthDoctrine\Controller',
                        'controller' => 'AuthDoctrine\Controller\Index',
                        'action'     => 'index',
                    ],
                ],

                'may_terminate' => true,

                'child_routes' => [
                    'default' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => '[:controller/[:action/[:id/]]]',

                            'constrains' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ]
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
        'display_exceptions' => true,

    ],

    'doctrine'=> [
        'authentication' => [
            'orm_default' => [
                'identity_class' => '\Blog\Entity\User',
                'identity_property' => 'usrName',
                'credential_property' => 'usrPassword',
                'credential_callable' => function(\Blog\Entity\User $user, $password){
//                    if($user->getUsrPassword() == md5('staticSalt' . $password . $user->getUsrPassword )){
                    if($user->getUsrPassword() == $password ){
                        return true;
                    } else {
                        return false;
                    }
                },

            ]
        ]
    ]
];