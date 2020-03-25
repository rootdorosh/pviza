<?php

return [
    'id' => '02',
    'name' => 'Advantage',
    'name_plural' => 'Advantages',
    'table' => 'advantage',
	'meta' => [
		'options' => [
			'categories' => 'ExtArrHelper::valueTextFromList($this->categoryFetchService->getList())',
		],
		'default' => [
			'rank' => '$this->fetchService->getDefaultRank()',	
			'is_active' => 1,
		],
	],
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
			'App\Modules\%module%\Services\Fetch\CategoryFetchService',
		],
	],
	
    'fields' => [
        'category_id' => [
            'label' => 'Category',
            'required' => true,
            'faker' => '\App\Modules\Advantage\Models\Category::all()->random()->id',
            'type' => 'integer',
            'uiType' => 'select',
			'optionsKey' => 'categories',
            'rules' => [
                'exists:advantage_categories,id',
            ],
            'filter' => true,
            'relation' => [
                'name' => 'category',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Advantage\Models\Category',
            ],			
            'migration' => [
                'foreign' => ['advantage_categories', 'CASCADE'],
                'type' => 'unsignedInteger',
                'default' => 1,
            ],
			/*
			'indexFiled' => [
				'name' => 'category',
				'transformer' => '$%model%->category->title',
			],
			*/
        ],
        'image' => [
            'label' => 'Image',
            'required' => false,
            'type' => 'image',
            'rules' => [
                'base64dimensions:min_width=400,min_height=300',
            ],
            'migration' => [
                'type' => 'string',
                'nullable' => true,
            ],
            'faker' => '$fakerService->imgPath()',
            'vue' => [
                'index' => true,
            ],
            //page index
            'index' => true,
        ],
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
		'svg_code' => [
			'label' => 'SVG code',
			'required' => false,
			'type' => 'string',
			'uiType' => 'textarea',
			'rules' => [
				'max: 10024',
			],
			'faker' => 'null',                
			'migration' => [
				'type' => 'longText',
				'nullable' => true,
			],
		],
    ],
    'translatable' => [
        'owner_id' => 'advantage_id',
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
            'body' => [
                'label' => 'Body',
                'required' => true,
                'faker' => '$faker->text(250)',                
                'type' => 'string',
                'rules' => [
                    'max: 10024',
                ],
                'migration' => [
                    'type' => 'longText',
                    'nullable' => true,
                ],
            ],
            
        ],
    ],    
    'routes' => [
        'path' => 'advantages',
        //'update_verb' => 'POST', //POST if image store
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
    'seeder' => [
        'count' => 100,
    ],
];