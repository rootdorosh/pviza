<?php 

return [
	'title' => 'Feedback',
	'items' => [
		'feedback' => [
			'actions' => [
				'feedback.feedback.index' => 'permission.index',
				'feedback.feedback.destroy' => 'permission.destroy',
				'feedback.feedback.view' => 'permission.view',
			],
		],
	],
];