<?php 

return [
	 [
		'id' => 'Advantage',
		'title' => 'advantage::advantage.title.index',
		'route' => '/advantage/advantages',
		'icon' => '',
		'permission' => 'advantage.advantage.index',
        'right' => false,
        'left' => true,
		'children' => [
			 [
				'id' => 'Category',
				'title' => 'advantage::category.title.index',
				'route' => '/advantage/categories',
				'icon' => '',
				'permission' => 'advantage.category.index',
			],
		],
	],
];