<?php

return [
    'id' => '04',
    'name' => 'Vacancy',
    'name_plural' => 'Vacancies',
    'table' => 'vacancy',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
			'App\Modules\%module%\Services\Fetch\CategoryFetchService',
			'App\Modules\%module%\Services\Fetch\LocationFetchService',
			'App\Modules\%module%\Services\Fetch\TypeFetchService',
		],
	],
	'meta' => [
		'default' => [
			'is_active' => 1,
			'is_popular' => 0,
			'rank' => '$this->fetchService->getDefaultRank()',
		],
		'options' => [
			'categories' => 'ExtArrHelper::valueTextFromList($this->categoryFetchService->getList())',
			'types' => 'ExtArrHelper::valueTextFromList($this->typeFetchService->getList())',
			'locations' => 'ExtArrHelper::valueTextFromList($this->locationFetchService->getList())',
		],        
	],
    'fields' => [
        'categories' => [
            'label' => 'Категорії',
            'migration' => false,
            'required' => true,
            'type' => 'array',
            'uiType' => 'multiSelect',
            'relation' => [
                'name' => 'categories',
                'type' => 'BelongsToMany',
                'model' => 'App\Modules\Vacancy\Models\Category',
                'table' => 'vacancy_vs_category',
                'tableBelong' => 'vacancy_categories',
            ],			
        ],
        'types' => [
            'label' => 'Типи',
            'migration' => false,
            'required' => true,
            'type' => 'array',
            'uiType' => 'multiSelect',
            'relation' => [
                'name' => 'types',
                'type' => 'BelongsToMany',
                'model' => 'App\Modules\Vacancy\Models\Type',
                'table' => 'vacancy_vs_type',
                'tableBelong' => 'vacancy_types',
            ],			
        ],
        'locations' => [
            'label' => 'Локації',
            'migration' => false,
            'required' => true,
            'type' => 'array',
            'uiType' => 'multiSelect',
            'relation' => [
                'name' => 'locations',
                'type' => 'BelongsToMany',
                'model' => 'App\Modules\Vacancy\Models\Location',
                'table' => 'vacancy_vs_location',
                'tableBelong' => 'vacancy_locations',
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
        'is_popular' => [
            'label' => 'Популярна',
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
        'date_posted' => [
            'label' => 'Дата розміщення',
            'type' => 'string',
            'required' => false,
            'rules' => [
                'max:255',
            ],    
            'migration' => [
                'nullable' => true,
            ],
            'filter' => false,
            'faker' => 'null',
        ],
        'hiring_organization' => [
            'label' => 'hiringOrganization',
            'type' => 'string',
            'required' => false,
            'rules' => [
                'max:255',
            ],    
            'migration' => [
                'nullable' => true,
            ],
            'filter' => false,
            'faker' => 'null',
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
        'owner_id' => 'vacancy_id',
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
            'salary' => [
                'label' => 'Заробітна плата',
                'type' => 'string',
                'required' => false,
                'rules' => [
                    'max:255',
                ],    
                'migration' => [
                    'nullable' => true,
                ],
                'filter' => false,
                'faker' => '$faker->text(50)',
            ],
            'work_schedule' => [
                'label' => 'Графік роботи',
                'type' => 'string',
                'required' => false,
                'rules' => [
                    'max:255',
                ],    
                'migration' => [
                    'nullable' => true,
                ],
                'filter' => false,
                'faker' => '$faker->text(50)',
            ],
            'contract_type' => [
                'label' => 'Тип договору',
                'type' => 'string',
                'required' => false,
                'rules' => [
                    'max:255',
                ],    
                'migration' => [
                    'nullable' => true,
                ],
                'filter' => false,
                'faker' => '$faker->text(50)',
            ],
            'description' => [
                'label' => 'Опис',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 10240',
                ],
                'faker' => '$faker->text(200)',                
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
        'path' => 'vacancies',
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