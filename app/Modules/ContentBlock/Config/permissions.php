<?php 

return [
	'title' => 'ContentBlock',
	'items' => [
		'contentBlock' => [
			'actions' => [
				'contentblock.contentblock.index' => 'permission.index',
				'contentblock.contentblock.store' => 'permission.store',
				'contentblock.contentblock.update' => 'permission.update',
				'contentblock.contentblock.destroy' => 'permission.destroy',
			],
		],
		'contentBlockPhoto' => [
			'actions' => [
				'contentblock.contentblock.photo.index' => 'permission.index',
				'contentblock.contentblock.photo.store' => 'permission.store',
				'contentblock.contentblock.photo.update' => 'permission.update',
				'contentblock.contentblock.photo.destroy' => 'permission.destroy',
			],
		],
	],
];