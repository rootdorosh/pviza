<?php

return [
    'id' => '01',
    'name' => 'Feedback',
    'name_plural' => 'Feedbacks',
    'table' => 'feedback',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
		],
	],
    'fields' => [
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
    ],
    'seeder' => [
        'count' => 10,
    ],
    'routes' => [
        'path' => 'feedbacks',
    ],
    'pageMap' => [
        //'update',
    ],
    'exceptCrud' => [
        'update',
        'store',
    ],
    'exceptClass' => [
    ],
    'uiView' => true,
];
