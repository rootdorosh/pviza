<?php

return [
    'id' => '01',
    'name' => 'Category',
    'name_plural' => 'Categories',
    'table' => 'advantage_categories',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
		],
	],
	'meta' => [
		'default' => [
			'rank' => '$this->fetchService->getDefaultRank()',
			'is_active' => 1,
		],
	],
    'fields' => [
        'is_active' => [
            'label' => 'Active',
            'required' => true,
            'faker' => 'rand(0,1)',
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'migration' => [
                'type' => 'boolean',
                'default' => 1,
            ],
        ],
        'rank' => [
            'label' => 'Rank',
            'required' => true,
            'faker' => 'rand(10,1000)',
            'type' => 'integer',
            'rules' => [
                'min:0',
            ],
            'filter' => true,
            'migration' => [
                'type' => 'integer',
                'default' => 10,
            ],
        ],
    ],
    'translatable' => [
        'owner_id' => 'category_id',
        'fields' => [
            'title' => [
                'label' => 'Title',
                'type' => 'string',
                'required' => true,
                'faker' => '$faker->text(50)',
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
            ],
            'description' => [
                'label' => 'Short description',
                'type' => 'string',
                'rules' => [
                    'max: 1024',
                ],
				'filter' => true,
                'faker' => '$faker->text(250)',                
                'migration' => [
                    'type' => 'text',
                    'nullable' => true,
                ],
            ],
        ],
    ],    
    'routes' => [
        'path' => 'categories',
        //'update_verb' => 'POST', //POST if image store
    ],
    'pageMap' => [
        //'update',
    ],
	'classConfig' => [
		'fetchService' => [
			'functions' => [
				'getList' => 'title',
				'getDefaultRank' => '10',
			],
		],
	],
    'seeder' => [
        'count' => 5,
    ],
    
];