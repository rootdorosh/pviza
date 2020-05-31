<?php 

return [
	'title' => 'Resume',
	'items' => [
		'resume' => [
			'actions' => [
				'resume.resume.index' => 'permission.index',
				'resume.resume.destroy' => 'permission.destroy',
				'resume.resume.view' => 'permission.view',
			],
		],
	],
];