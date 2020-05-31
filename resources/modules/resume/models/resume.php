<?php

return [
    'id' => '01',
    'name' => 'Resume',
    'name_plural' => 'Resumes',
    'table' => 'resume',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
			'App\Modules\Vacancy\Services\Fetch\VacancyFetchService',
		],
	],
	'meta' => [
		'options' => [
			'vacancies' => 'ExtArrHelper::valueTextFromList($this->vacancyFetchService->getList())',
		],        
	],
    'fields' => [
        'vacancy_id' => [
            'module' => 'vacancy',
            'label' => 'Vacancy',
            'required' => true,
            'faker' => '\App\Modules\Vacancy\Models\Vacancy::all()->random()->id',
            'type' => 'integer',
            'uiType' => 'select',
			'optionsKey' => 'vacancies',
            'rules' => [
                'exists:vacancy,id',
            ],
            'filter' => true,
            'relation' => [
                'name' => 'vacancy',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Vacancy\Models\Vacancy',
                'title_attr' => 'title',
            ],			
            'migration' => [
                'foreign' => ['vacancy', 'CASCADE'],
                'type' => 'unsignedInteger',
                'nullable' => true,
            ],
            'editable' => false,
        ],
        'created_at' => [
            'label' => 'Created at',
            'required' => true,
            'type' => 'datetime',
            'rules' => [
            ],
            'migration' => [
                'type' => 'integer',
            ],
            'faker' => 'time()',
            'vue' => [
                'index' => true,
            ],
            'mutator' => [
                'set' => 'fromDatetimeToInt',
            ],   
            'filter' => true,
            'editable' => false,
            'fransformer' => [
                // default: datetime_to_ui
                // datetime_to_ui, config.scms
                'format' => 'config.scms',
            ],
        ],
        'name' => [
            'label' => 'Name',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '$faker->word',
        ],        
        'email' => [
            'label' => 'Email',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '$faker->email',
        ],        
        'phone' => [
            'label' => 'Phone',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '911',
        ],        
        'message' => [
            'label' => 'Message',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:1024',
            ],    
            'filter' => false,
            'migration' => [
                'nullable' => true,
                'type' => 'text',
            ],
			'faker' => '$faker->text(120)',
        ],
        'document' => [
            'label' => 'File',
            'type' => 'string',
            'required' => true,
            'rules' => [
            ],    
            'filter' => false,
            'migration' => [
                'nullable' => true,
                'type' => 'string',
            ],
            'editable' => false,
        ],
    ],    
    'seeder' => [
        'count' => 10,
    ],	
    'routes' => [
        'path' => 'resumes',
    ],
    'pageMap' => [
        //'update',
    ],
    'exceptCrud' => [
        'store', 
        'update', 
    ],
    'uiView' => true,
];