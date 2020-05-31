<?php

return [
    // blog page pager
    [
        'key' => '/^viza-work-blog\/page-([0-9]*)\/?$/',
        'vars' => 'page',
        'path' => 'viza-work-blog',
    ],
    // blog category page pager
    [
        'key' => '/^category\/([^\/]*)\/page-([0-9]*)\/?$/',
        'vars' => 'alias,page',
        'path' => 'viza-work-blog/category',
    ],
    // blog category page
    [
        'key' => '/^category\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'viza-work-blog/category',
    ],
    // blog page
    [
        'key' => '/^([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'viza-work-blog/view',
        'rank' => 100,
    ],
];
