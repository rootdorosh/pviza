<?php 

$simpleSizes = [
	'480x280' => [
		'width' => 480,
		'height' => 280,
		'minWidth' => 0,
	],
	'768x480' => [
		'width' => 768,
		'height' => 480,
		'minWidth' => 481,
	],
	'1024x640' => [
		'width' => 1024,
		'height' => 640,
		'minWidth' => 769,
	],
];

return [
    'ContentBlock' => [
        'adaptive_image' => $simpleSizes,
    ],
];