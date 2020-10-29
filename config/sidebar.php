<?php

return [
    'links'=>[
        [
            'name'  =>'Dashboard',
            'icon'  =>'mdi mdi-view-dashboard-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'  =>'Default',
                    'new'   =>true,
                    'color' =>'danger',
                    'route' =>'dashboard.index'
                ]
            ],
        ],
        [
            'name'  =>'Admins',
            'icon'  =>'mdi mdi-account-multiple-plus-outline',
            'active'=>false,
            'sub'   =>[
                [
                    'name'=>'Admins',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Admin.index'
                ],
                [
                    'name'=>'Create Admin',
                    'new'   =>false,
                    'color' =>'danger',
                    'route' =>'Admin.create'
                ]
            ],
        ],
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
        ]
    ]
];
