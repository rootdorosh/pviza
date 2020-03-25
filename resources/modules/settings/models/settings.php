<?php

return [
    'id' => '01',
    'name' => 'Settings',
    'name_plural' => 'Settings',
    'table' => 'settings',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
		],
	],
    'fields' => [
        'key' => [
            'label' => 'Key',
            'type' => 'string',
            'required' => true,
            'faker' => 'null',
            'rules' => [
                'max:255',
			],    
            'filter' => true,
        ],
        'value' => [
            'label' => 'Value',
            'type' => 'string',
            'required' => true,
            'faker' => 'null',
            'rules' => [
                'max:255',
			],    
            'filter' => true,
            'migration' => [
                'type' => 'text',
                'nullable' => true,
            ],
        ],
    ],
    'seeder' => false,	
    'routes' => [
        'path' => 'settings',
    ],
    'pageMap' => [
        //'update',
    ],    
];