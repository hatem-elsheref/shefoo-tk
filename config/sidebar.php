<?php

return [
    'links'=>[
        // dashboard
        [
            'name'  =>'dashboard',
            'icon'  =>'mdi mdi-view-dashboard-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'  =>'default',
                    'new'   =>true,
                    'color' =>'danger',
                    'route' =>'dashboard.index'
                ]
            ],
        ],
        [
            'name'  =>'blog',
            'icon'  =>'mdi mdi-blogger',
            'active'=>false,
            'sub'   =>[
                [
                    'name'  =>'posts',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Post.index'
                ],
                [
                    'name'  =>'categories',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Category.index'
                ],
                [
                    'name'  =>'tags',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Tag.index'
                ],
                [
                    'name'  =>'trashed',
                    'new'   =>true,
                    'color' =>'success',
                    'route' =>'Post.trashed'
                ]
            ],
        ],

        // admin
        [
            'name'  =>'admins',
            'icon'  =>'mdi mdi-account-multiple-plus-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'=>'admins',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Admin.index'
                ],
                [
                    'name'=>'create_admin',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Admin.create'
                ]
            ],
        ],
        // group
        [
            'name'  =>'groups',
            'icon'  =>'mdi mdi-account-group-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'=>'groups',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'group.index'
                ],
                [
                    'name'=>'create_group',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'group.create'
                ]
            ],
        ],
        // setting
        [
            'name'  =>'settings',
            'icon'  =>'mdi mdi-settings',
            'active'=>false,
            'sub'   =>[
              /*  [
                    'name'  =>'overview',
                    'new'   =>true,
                    'color' =>'secondary',
                    'route' =>'setting.index'
                ],*/
                [
                    'name'  =>'translations',
                    'new'   =>true,
                    'color' =>'warning',
                    'route' =>'translation.index'
                ],
                /*[
                    'name'  =>'log',
                    'new'   =>true,
                    'color' =>'info',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'system',
                    'new'   =>true,
                    'color' =>'danger',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'seo',
                    'new'   =>true,
                    'color' =>'success',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'slack_telegram',
                    'new'   =>true,
                    'color' =>'dark',
                    'route' =>'dashboard.index'
                ]*/
            ],
        ],
    ]
];
