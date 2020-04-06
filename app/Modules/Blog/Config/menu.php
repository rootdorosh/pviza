<?php 

return [
	 [
		'id' => 'Blog',
		'title' => 'blog::blog.title.index',
		'route' => '/blog/blogs',
		'icon' => '',
		'permission' => 'blog.blog.index',
		'right' => false,
		'left' => true,
		'children' => [
			 [
				'id' => 'Category',
				'title' => 'blog::category.title.index',
				'route' => '/blog/categories',
				'icon' => '',
				'permission' => 'blog.category.index',
			],
		],
	],
];