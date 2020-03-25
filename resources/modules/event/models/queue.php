<?php

return [
    'id' => '02',
    'name' => 'Queue',
    'name_plural' => 'Queues',
    'table' => 'event_queue',
	'depedencies' => [
		'controller' => [
			'App\Services\Response\FractalManager',
			'App\Modules\%module%\Transformers\%model%Transformer',
			'App\Modules\%module%\Services\Crud\%model%CrudService',
			'App\Modules\%module%\Services\Fetch\%model%FetchService',
		],
	],
    'consts' => [
        'STATUS' => [
            'plurar' => 'STATUSES',
            'items' => [
                'await',
                'send',
                'fail',
            ],
        ],
    ],   
    'fields' => [
        'event_id' => [
            'label' => 'Event',
            'required' => true,
            'type' => 'integer',
            'uiType' => 'select',
			'optionsKey' => 'events',
            'rules' => [
                'exists:event,id',
            ],
            'filter' => true,
            'relation' => [
                'name' => 'event',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Event\Models\Event',
            ],			
            'migration' => [
                'foreign' => ['event', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],
        'status' => [
            'label' => 'Status',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                '\'in:\' . implode(',', array_flip(App\Modules\Event\Models\Queue::STATUSES))',
            ],
            'migration' => [
                'type' => 'tinyInteger',
            ],
        ],       
        'from_email' => [
            'label' => 'From email',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
        ],        
        'from_name' => [
            'label' => 'From name',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
        ],        
        'email_to' => [
            'label' => 'Email to',
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],
        ],        
        'subject' => [
            'label' => 'Subject',
            'type' => 'string',
            'required' => true,
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
            'type' => 'string',
            'required' => true,
            'rules' => [
                'max:255',
            ],    
            'filter' => true,
            'migration' => [
                'type' => 'longText',
                'nullable' => true,
            ],            
        ],        
        'created_time' => [
            'label' => 'Created time',
            'type' => 'integer',
            'uiType' => 'datetime',
            'required' => true,
            'filter' => true,
        ],        
        'sended_time' => [
            'label' => 'Sended time',
            'type' => 'integer',
            'uiType' => 'datetime',
            'required' => false,
            'filter' => true,
            'migration' => [
                'nullable' => true,
            ],            
        ],        
        'files' => [
            'label' => 'Files',
            'type' => 'string',
            'required' => false,
            'filter' => false,
            'migration' => [
                'type' => 'text',
                'nullable' => true,
            ],            
        ],        
    ],
    'seeder' => false,	
    'routes' => [
        'path' => 'queue',
    ],
    'pageMap' => [
        //'update',
    ],
    'exceptCrud' => [
        'update',
        'store',
    ],
    'exceptClass' => [
        'Factory',
        'Seeder',
    ],
];