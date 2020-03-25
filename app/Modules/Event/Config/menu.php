<?php 

return [
	 [
		'id' => 'Event',
		'title' => 'event::event.title.index',
		'route' => '/event/events',
		'icon' => '',
		'permission' => 'event.event.index',
        'right' => true,
        'left' => false,
		'children' => [
			 [
				'id' => 'Queue',
				'title' => 'event::queue.title.index',
				'route' => '/event/queue',
				'icon' => '',
				'permission' => 'event.queue.index',
			],
		],
	],
];