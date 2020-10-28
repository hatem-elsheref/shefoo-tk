<?php

return [
    'models'=>[
        'Admin'     =>['c','r','d','u'],
        'User'      =>['u','r','d'],
        'Role'      =>['c','r','d','u'],
        'Category'  =>['c','r','d','u'],
        'Tag'       =>['c','r','d','u'],
        'Post'      =>['c','r','d','u'],
        'Comment'   =>['c','r','d','u']
    ],


    'map'=>[
        'c' =>'create',
        'r' =>'read',
        'd' =>'delete',
        'u' =>'update'
    ],

    'administratorGroup'=>[
        'name'          =>'admin',
        'display_name'  =>'Administrator'
    ]
];
