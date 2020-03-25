<?php 

return [
	'title' => 'Advantage',
	'items' => [
		'category' => [
			'actions' => [
				'advantage.category.index' => 'permission.index',
				'advantage.category.store' => 'permission.store',
				'advantage.category.update' => 'permission.update',
				'advantage.category.destroy' => 'permission.destroy',
			],
		],
		'advantage' => [
			'actions' => [
				'advantage.advantage.index' => 'permission.index',
				'advantage.advantage.store' => 'permission.store',
				'advantage.advantage.update' => 'permission.update',
				'advantage.advantage.destroy' => 'permission.destroy',
			],
		],
	],
];