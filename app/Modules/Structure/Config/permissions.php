<?php

return [
    'title' => 'Модуль "Структура"',
    'items' => [
        'domain' => [
            'title' => 'Домены',
            'actions' => [
                'structure.domain.index' => 'permission.index',
                'structure.domain.store' => 'permission.store',
                'structure.domain.update' => 'permission.update',
                'structure.domain.destroy' => 'permission.destroy',
            ],
        ],
        'page' => [
            'title' => 'Страницы',
            'actions' => [
                'structure.page.index' => 'permission.index',
                'structure.page.store' => 'permission.store',
                'structure.page.update' => 'permission.update',
                'structure.page.destroy' => 'permission.destroy',
                'structure.page.move' => 'permission.move',
                'structure.page.copy' => 'permission.copy',
            ],
        ],
        'block' => [
            'title' => 'Блоки страницы',
            'actions' => [
                'structure.block.index' => 'permission.index',
                'structure.block.insert' => 'permission.insert',
                'structure.block.destroy' => 'permission.destroy',
            ],
        ],
    ]
];
