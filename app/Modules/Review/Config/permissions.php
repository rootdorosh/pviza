<?php 

return [
	'title' => 'Review',
	'items' => [
		'review' => [
			'actions' => [
				'review.review.index' => 'permission.index',
				'review.review.store' => 'permission.store',
				'review.review.update' => 'permission.update',
				'review.review.destroy' => 'permission.destroy',
			],
		],
	],
];