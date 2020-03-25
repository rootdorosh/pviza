<?php

return [
    [
        'title' => 'Users',
        'route' => '/user/users',
        'icon' => 'icon-user-users',
        'permission' => 'user.user.index',
        'right' => true,
        'left' => false,
        'children' => [
            [
                'title' => 'Roles',
                'route' => '/user/roles',
                'icon' => 'icon-user-roles',
                'permission' => 'user.role.index',
            ]
        ],
    ],
    
];
    