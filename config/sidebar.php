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
            'name'  =>'Groups',
            'icon'  =>'mdi mdi-account-group-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'=>'Groups',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'group.index'
                ],
                [
                    'name'=>'Create Group',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'group.create'
                ]
            ],
        ],
        // setting
        [
            'name'  =>'Settings',
            'icon'  =>'mdi mdi-settings',
            'active'=>false,
            'sub'   =>[
                [
                    'name'  =>'OverView',
                    'new'   =>true,
                    'color' =>'secondary',
                    'route' =>'setting.index'
                ],
                [
                    'name'  =>'Translations',
                    'new'   =>true,
                    'color' =>'warning',
                    'route' =>'translation.index'
                ],
                [
                    'name'  =>'Logs',
                    'new'   =>true,
                    'color' =>'info',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'System',
                    'new'   =>true,
                    'color' =>'danger',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'Seo',
                    'new'   =>true,
                    'color' =>'success',
                    'route' =>'dashboard.index'
                ],
                [
                    'name'  =>'Slack & Telegram',
                    'new'   =>true,
                    'color' =>'dark',
                    'route' =>'dashboard.index'
                ]
            ],
        ],
    ]
];
