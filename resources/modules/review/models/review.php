<?php

return [
    'id' => '04',
    'name' => 'Review',
    'name_plural' => 'Reviews',
    'table' => 'review',
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
			'is_active' => 1,
			'is_home' => 0,
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
        'created_at' => [
            'label' => 'Дата створення',
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
        ],
        'name' => [
            'label' => 'Имя',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],
            'filter' => true,
            'faker' => '$faker->word',
        ],
        'email' => [
            'label' => 'E-mail',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'email',
            ],
            'filter' => true,
            'faker' => '$faker->email',
            'migration' => [
                'nullable' => true,
            ],
        ],
        'comment' => [
            'label' => 'Коментар',
            'type' => 'string',
            'required' => true,
            'rules' => [
            ],
            'uiType' => 'textarea',
            'filter' => true,
            'faker' => '$faker->text(200)',
            'migration' => [
                'type' => 'longText',
            ],
        ],
    ],
    'seeder' => [
        'count' => 10,
    ],
    'routes' => [
        'path' => 'reviews',
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
