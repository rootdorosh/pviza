<?php

return [
    'id' => '01',
    'name' => 'Menu',
    'name_plural' => 'Menus',
    'table' => 'menu',
    'fields' => [
        'domain_id' => [
            'label' => 'Domain',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:structure_domains,id',
            ],
            'faker' => 'App\Modules\Structure\Models\Domain::randon()->id',
            'relation' => [
                'name' => 'domain',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Structure\Models\Domain',
            ],
            'migration' => [
                'foreign' => ['structure_domains', 'CASCADE'],
                'type' => 'unsignedInteger',
                //'default' => '1',
                //'nullable' => true,
                //'comment' => 'Domain',
            ],
        ],
        'title' => [
            'label' => 'Title',
            'required' => true,
            'type' => 'string',
            'rules' => [
                'max:255',
            ],
            'faker' => '$faker->text(60)',
        ],
        'is_active' => [
            'label' => 'Active',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'nullable' => true,
                'default' => 1,
            ],
        ],
        'is_sitemap' => [
            'label' => 'Sitemap',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'nullable' => true,
                'default' => 0,
            ],
        ],
    ],    
    'routes' => [
        'path' => 'menus',
        //'update_verb' => 'PUT', //POST if image store
    ],
];