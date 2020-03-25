<?php

return [
    'id' => '03',
    'parentModel' => 'ContentBlock',
    'name' => 'Photo',
    'name_plural' => 'Photos',
    'table' => 'content_blocks_photos',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%parent%\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%parent%\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%parent%\%model%FetchService',
		],
	],
    'consts' => [
        'TYPE' => [
            'plurar' => 'TYPES',
            'items' => [
                'image',
                'map',
                'plan',
            ],
        ],
    ],    
    'fields' => [
        'image' => [
            'label' => 'Image',
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
            //page index
            'index' => true,
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
                'default' => 1,
            ],
        ],
        'type' => [
            'label' => 'Type',
            'required' => false,
            'type' => 'integer',
            'rules' => [
            ],
            'uiType' => 'select',
            'options' => 'ExtArrHelper::valueTextFromList(PHOTO::TYPES)',
            'faker' => '$faker->randomElement(array_flip(PHOTO::TYPES))',
            'migration' => [
                'type' => 'tinyInteger',
                'nullable' => true,
            ],
        ],
        'rank' => [
            'noInFormRequest' => true,
            'label' => 'Rank',
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
        'owner_id' => 'photo_id',
        'fields' => [
            'title' => [
                'label' => 'Title',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => '$faker->text(50)',
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'string',
                'rules' => [
                    'max:1024',
                ],    
                'filter' => true,
                'faker' => '$faker->text(200)',
                'migration' => [
                    'type' => 'longText',
                    'nullable' => true,
                ],                
            ],
        ],
    ],    
	'classConfig' => [
		'fetchService' => [
			'functions' => [
				//'getDefaultRank' => '10',
			],
		],
	],	
    'seeder' => [
        'count' => 5,
    ],	
    'routes' => [
        'path' => 'photos',
    ],
	'skip' => [
	],
    'listGrid' => [
        'description-attr' => 'description',
        'image-attr' => 'image',
        'inactive-attr' => 'is_active',
    ],
];
 