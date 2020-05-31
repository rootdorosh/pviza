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
        'docs' => [
            'label' => 'Files',
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
			'faker' => 'null',
        ],
        'ip' => [
            'label' => 'Ip',
            'type' => 'string',
            'required' => true,
            'filter' => false,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '"127.0.0.1"',
        ],
        'browser' => [
            'label' => 'Browser',
            'type' => 'string',
            'required' => true,
            'filter' => false,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '"chrome"',			
        ],
        'device' => [
            'label' => 'Device',
            'type' => 'string',
            'required' => true,
            'filter' => false,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '"android"',
        ],
        'monitor' => [
            'label' => 'Monitor',
            'type' => 'string',
            'required' => true,
            'filter' => false,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '"1900x1600"',
        ],
        'url' => [
            'label' => 'Url',
            'type' => 'string',
            'required' => true,
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
			'faker' => '$faker->word',
        ],
        'created_time' => [
            'label' => 'Created time',
            'type' => 'datetime',
            'required' => false,
            'filter' => true,
            'filterable' => false,
            'faker' => 'time()',
            'migration' => [
                'type' => 'integer',
            ],   
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