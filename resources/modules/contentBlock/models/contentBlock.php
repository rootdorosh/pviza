<?php

return [
    'id' => '01',
    'name' => 'ContentBlock',
    'name_plural' => 'ContentBlocks',
    'table' => 'content_blocks',
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
			'is_hide_editor' => 0,
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
        'name' => [
            'label' => 'Name',
            'required' => true,
            'type' => 'string',
            'rules' => [
                'max:255',
            ],
            'faker' => '$faker->text(120)',
            'filter' => true,
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
        'is_hide_editor' => [
            'label' => 'Hide editor',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'default' => 0,
            ],
        ],
        'adaptive_image' => [
            'label' => 'Adaptive images',
            'required' => false,
            'type' => 'string',
            'uiType' => 'AdaptiveImage',
            'rules' => [
            ],
            'migration' => [
                'type' => 'json',
                'nullable' => true,
            ],
            //'faker' => '$fakerService->adaptiveImage("%module%", "%model%")',
            'faker' => 'null',
        ],        
    ],
    'translatable' => [
        'owner_id' => 'content_block_id',
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
            'body' => [
                'label' => 'Body',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'max: 10024',
                ],
                'faker' => '$faker->text(250)',                
                'migration' => [
                    'type' => 'longText',
                    'nullable' => true,
                ],
            ],            
        ],
    ],    
    'seeder' => [
        'count' => 10,
    ],	
    'routes' => [
        'path' => 'content-blocks',
        //'update_verb' => 'POST', //POST if image store
    ],
    'pageMap' => [
        //'update',
    ],
	/*
	'skip' => [
		'migration',
		'controller',
		'form.js',
		'Form.vue',
	],
	*/
];