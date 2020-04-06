<?php 

return [
	'title' => 'Blog',
	'items' => [
		'category' => [
			'actions' => [
				'blog.category.index' => 'permission.index',
				'blog.category.store' => 'permission.store',
				'blog.category.update' => 'permission.update',
				'blog.category.destroy' => 'permission.destroy',
			],
		],
		'blog' => [
			'actions' => [
				'blog.blog.index' => 'permission.index',
				'blog.blog.store' => 'permission.store',
				'blog.blog.update' => 'permission.update',
				'blog.blog.destroy' => 'permission.destroy',
			],
		],
	],
];