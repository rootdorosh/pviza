<?php 

return [
	'title' => 'Vacancy',
	'items' => [
		'category' => [
			'actions' => [
				'vacancy.category.index' => 'permission.index',
				'vacancy.category.store' => 'permission.store',
				'vacancy.category.update' => 'permission.update',
				'vacancy.category.destroy' => 'permission.destroy',
			],
		],
		'type' => [
			'actions' => [
				'vacancy.type.index' => 'permission.index',
				'vacancy.type.store' => 'permission.store',
				'vacancy.type.update' => 'permission.update',
				'vacancy.type.destroy' => 'permission.destroy',
			],
		],
		'location' => [
			'actions' => [
				'vacancy.location.index' => 'permission.index',
				'vacancy.location.store' => 'permission.store',
				'vacancy.location.update' => 'permission.update',
				'vacancy.location.destroy' => 'permission.destroy',
			],
		],
		'vacancy' => [
			'actions' => [
				'vacancy.vacancy.index' => 'permission.index',
				'vacancy.vacancy.store' => 'permission.store',
				'vacancy.vacancy.update' => 'permission.update',
				'vacancy.vacancy.destroy' => 'permission.destroy',
			],
		],
	],
];