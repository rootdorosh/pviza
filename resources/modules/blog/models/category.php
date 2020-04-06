<?php

return [
    'id' => '01',
    'name' => 'Category',
    'name_plural' => 'Categories',
    'table' => 'blog_categories',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
		],
        'services' => [
            'crud' => [
                'App\Services\SlugService',
            ],
        ],
	],
	'meta' => [
		'default' => [
			'is_active' => 1,
			'rank' => '$this->fetchService->getDefaultRank()',
		],
	],
    'fields' => [
        'is_active' => [
            'label' => 'Активність',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'default' => 1,
            ],
        ],
        'rank' => [
            'label' => 'Порядок виводу',
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
        'image' => [
            'label' => 'Зображення в хедері',
            'required' => false,
            'type' => 'image',
            'rules' => [
            ],
            'migration' => [
                'type' => 'string',
                'nullable' => true,
            ],
            'faker' => '$fakerService->imgPath()',
            'vue' => [
                'index' => true,
            ],
        ]
    ],
    'translatable' => [
        'owner_id' => 'category_id',
        'fields' => [
            'title' => [
                'label' => 'Заголовок',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => '$faker->text(50)',
            ],
            'alias' => [
                'label' => 'Alias',
                'type' => 'string',
                'required' => false,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => '$faker->word',
            ],
            'description' => [
                'label' => 'Опис',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'max: 1024',
                ],
                'faker' => '$faker->text(250)',                
                'migration' => [
                    'type' => 'longText',
                    'nullable' => true,
                ],
            ],            			
            'seo_h1' => [
                'label' => 'seo H1',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 255',
                ],
                'faker' => '$faker->text(80)',                
                'migration' => [
                    'nullable' => true,
                ],
            ],            			
            'seo_title' => [
                'label' => 'meta title',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 255',
                ],
                'faker' => '$faker->text(80)',                
                'migration' => [
                    'nullable' => true,
                ],
            ],            			
            'seo_description' => [
                'label' => 'meta description',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 255',
                ],
                'faker' => '$faker->text(80)',                
                'migration' => [
                    'nullable' => true,
                ],
            ],            			
        ],
    ],    
    'seeder' => [
        'source' => "\$data = [
            [
                'title' => 'Все о работе',
                'alias' => 'aaaaaaaaaaaa',
                'is_active' => 1,
            ],
            [
                'title' => 'Все о штрафах',
                'alias' => 'bbbbbbbbbbb',
                'is_active' => 1,
            ],
        ];",
    ],	    
    'routes' => [
        'path' => 'categories',
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
    
];