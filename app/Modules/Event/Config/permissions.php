<?php 

return [
	'title' => 'Event',
	'items' => [
		'event' => [
			'actions' => [
				'event.event.index' => 'permission.index',
				'event.event.update' => 'permission.update',
				'event.event.destroy' => 'permission.destroy',
			],
		],
		'queue' => [
			'actions' => [
				'event.queue.index' => 'permission.index',
				'event.queue.destroy' => 'permission.destroy',
			],
		],
	],
];