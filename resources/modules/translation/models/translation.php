<?php

return [
    'id' => '04',
    'name' => 'Translation',
    'name_plural' => 'Translations',
    'table' => 'translations',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
		],
	],
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'type' => 'string',
            'required' => true,
            'faker' => 'null',
            'rules' => [
                'max:255',
			],    
            'filter' => true,
        ],
    ],
    'translatable' => [
        'owner_id' => 'trans_id',
        'fields' => [
            'value' => [
                'label' => 'Value',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => 'null',
            ],
        ],
    ],    
    'seeder' => false,	
    'routes' => [
        'path' => 'translations',
    ],
    'pageMap' => [
        //'update',
    ],    
];