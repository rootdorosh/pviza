<?php

return [
    'id' => '01',
    'name' => 'Event',
    'name_plural' => 'Events',
    'table' => 'event',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
		],
	],
	'meta' => [
		'default' => [
			'is_active' => 1,
		],
	],
    'consts' => [
        'CONTENT_TYPE' => [
            'plurar' => 'CONTENT_TYPES',
            'items' => [
                'text_plain',
                'text_html',
            ],
        ],
    ],    
    'fields' => [
        'event_id' => [
            'label' => 'Event ID',
            'required' => true,
            'type' => 'string',
            'rules' => [
            ],
            'migration' => [
                'type' => 'string',
                'nullable' => true,
                'unique' => true,
            ],
            'vue' => [
                'index' => true,
            ],
            //page index
            'index' => true,
        ],
        'content_type' => [
            'label' => 'Content type',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                '\'in:\' . implode(',', array_flip(App\Modules\Event\Models\Event::CONTENT_TYPES))',
            ],
            'migration' => [
                'type' => 'tinyInteger',
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'required' => true,
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
        'from_email' => [
            'label' => 'From email',
            'required' => false,
            'type' => 'string',
            'rules' => [
            ],
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
        ],
    ],
    'translatable' => [
        'owner_id' => 'event_id',
        'fields' => [
            'subject' => [
                'label' => 'Subject',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
            ],
            'from_name' => [
                'label' => 'From name',
                'type' => 'string',
                'required' => false,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'migration' => [
                    'nullable' => true,
                ],
            ],
            'body' => [
                'label' => 'Body',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'max: 10024',
                ],
                'migration' => [
                    'type' => 'longText',
                ],
            ],
        ],
    ],    
    'seeder' => false,
    'routes' => [
        'path' => 'events',
    ],
    'pageMap' => [
        //'update',
    ],
	'classConfig' => [
		'fetchService' => [
			'functions' => [
				'getList' => 'subject',
			],
		],
	],
    'exceptCrud' => [
        'store',
    ],    
    'exceptClass' => [
        'Factory',
        'Seeder',
    ],
];