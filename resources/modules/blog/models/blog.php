<?php

return [
    'id' => '04',
    'name' => 'Blog',
    'name_plural' => 'Blogs',
    'table' => 'blog',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
			'App\Modules\%module%\Services\Fetch\CategoryFetchService',
		],
	],
	'meta' => [
		'default' => [
			'is_active' => 1,
			'is_home' => 0,
		],
		'options' => [
			'categories' => 'ExtArrHelper::valueTextFromList($this->categoryFetchService->getList())',
		],        
	],
    'fields' => [
        'category_id' => [
            'label' => 'Категорія',
            'required' => true,
            'faker' => '\App\Modules\Blog\Models\Category::all()->random()->id',
            'type' => 'integer',
            'uiType' => 'select',
			'optionsKey' => 'categories',
            'rules' => [
                'exists:blog_categories,id',
            ],
            'filter' => true,
            'relation' => [
                'name' => 'category',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Blog\Models\Category',
            ],			
            'migration' => [
                'foreign' => ['blog_categories', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
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
        'is_home' => [
            'label' => 'На головну',
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
        'image' => [
            'label' => 'Зображення',
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
        ],        
        'image_header' => [
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
                'index' => false,
            ],
        ],        
        'created_at' => [
            'label' => 'Дата створення',
            'required' => true,
            'type' => 'datetime',
            'mutator' => [
                'set' => 'fromDatetimeToInt',
            ],
            'rules' => [
            ],
            'migration' => [
                'type' => 'integer',
            ],
            'faker' => 'time()',
            'vue' => [
                'index' => true,
            ],
        ]        
    ],
    'translatable' => [
        'owner_id' => 'blog_id',
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
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 10240',
                ],
                'faker' => '$faker->text(80)',                
                'migration' => [
                    'type' => 'longText',
                    'nullable' => true,
                ],
            ],            			            
            'seo_h1' => [
                'label' => 'seo h1',
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
        'count' => 10,
    ],	
    'routes' => [
        'path' => 'blogs',
    ],
    'pageMap' => [
        //'update',
    ],
	'classConfig' => [
		'fetchService' => [
			'functions' => [
				'getDefaultRank' => '10',
			],
		],
	],    
    
];