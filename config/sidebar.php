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
