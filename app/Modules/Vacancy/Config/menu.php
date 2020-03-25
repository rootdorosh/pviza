<?php 

return [
	 [
		'id' => 'Vacancy',
		'title' => 'vacancy::vacancy.title.index',
		'route' => '/vacancy/vacancies',
		'icon' => '',
		'permission' => 'vacancy.vacancy.index',
		'right' => false,
		'left' => true,
		'children' => [
			 [
				'id' => 'Category',
				'title' => 'vacancy::category.title.index',
				'route' => '/vacancy/categories',
				'icon' => '',
				'permission' => 'vacancy.category.index',
			],
			 [
				'id' => 'Type',
				'title' => 'vacancy::type.title.index',
				'route' => '/vacancy/types',
				'icon' => '',
				'permission' => 'vacancy.type.index',
			],
			 [
				'id' => 'Location',
				'title' => 'vacancy::location.title.index',
				'route' => '/vacancy/locations',
				'icon' => '',
				'permission' => 'vacancy.location.index',
			],
		],
	],
];