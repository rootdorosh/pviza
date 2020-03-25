<?php 

return [
    'title' => 'Модуль "Menu"',
    'items' => [
        'menu' => [
            'actions' => [
                'menu.menu.index' => 'permission.index',
                'menu.menu.store' => 'permission.store',
                'menu.menu.update' => 'permission.update',
                'menu.menu.destroy' => 'permission.destroy',
            ],
        ],
        'item' => [
            'actions' => [
                'menu.item.index' => 'permission.index',
                'menu.item.store' => 'permission.store',
                'menu.item.update' => 'permission.update',
                'menu.item.destroy' => 'permission.destroy',
            ],
        ],
    ],
];