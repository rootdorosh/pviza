<?php

$changefreqs = [
];

return [
    'id' => '02',
    'name' => 'Item',
    'name_plural' => 'Items',
    'table' => 'menu_items',
    'consts' => [
        'CHANGEFREQ' => [
            'plurar' => 'CHANGEFREQS',
            'items' => [
                'always',
                'hourly',
                'daily',
                'weekly',
                'monthly',
                'yearly',
                'never',                            
            ],
        ],
    ],
    'fields' => [
        'menu_id' => [
            'label' => 'Menu',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:menus,id',
            ],
            'relation' => [
                'name' => 'menu',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Menu\Models\Menu',
            ],
            'migration' => [
                'foreign' => ['menu', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],
        'parent_id' => [
            'label' => 'Parent',
            'required' => false,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:menu_items,id',
            ],
            'relation' => [
                'name' => 'parent',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Menu\Models\Item',
            ],
            'migration' => [
                'foreign' => ['menu_items', 'CASCADE'],
                'type' => 'unsignedInteger',
                'nullable' => true,
            ],
        ],
        'page_id' => [
            'label' => 'Page',
            'required' => false,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:structure_pages,id',
            ],
            'relation' => [
                'name' => 'page',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Structure\Models\Page',
            ],
            'migration' => [
                'foreign' => ['structure_pages', 'CASCADE'],
                'type' => 'unsignedInteger',
                'nullable' => true,
            ],
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
        'is_targer_blank' => [
            'label' => 'Target blank',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'default' => 0,
            ],
        ],
        'rank' => [
            'label' => 'Rank',
            'required' => false,
            'type' => 'integer',
            'rules' => [
                'integer',
                'min:0',
            ],
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'integer',
                'default' => 0,
            ],
        ],
        'changefreq' => [
            'label' => 'Sitemap changefreq',
            'required' => false,
            'type' => 'string',
            'rules' => [
                'string',
                '\'in:\' . implode(',', array_flip(App\Modules\Menu\Models\Item::CHANGEFREQS))',
            ],
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'tinyInteger',
                'nullable' => true,
            ],
        ],
        'priority' => [
            'label' => 'Sitemap priority',
            'required' => false,
            'type' => 'decimal',
            'rules' => [
                'numeric',
            ],
            'migration' => [
                'type' => 'decimal',
                'length' => '2, 1',
            ],
        ],
    ], 
    'translatable' => [
        'owner_id' => 'item_id',
        'fields' => [
            'title' => [
                'label' => 'Title',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => '$faker->text(20)',
            ],
            'link' => [
                'label' => 'Link',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max:255',
                ],
                'migration' => [
                    'type' => 'string',
                    'nullable' => true,
                ],
                'faker' => 'null',
            ],
            'description' => [
                'label' => 'Description',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'max: 255',
                ],
                'faker' => '$faker->text(250)',                
            ],
            
        ],
    ],        
    'routes' => [
        'path' => 'menus/{menu}/items',
        //'update_verb' => 'PUT', //POST if image store
    ],
];