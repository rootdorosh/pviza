<?php 

return [
    // новости - категория - пагинация
    [
        'key' => '/^news-([^\/]*)\/page-([0-9]*)\/?$/',
        'vars' => 'alias, page',
        'path' => 'news/category',
    ],
    // новости - категория - пагинация
    [
        'key' => '/^news-([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'news/category',
    ],
    // новости - пагинация
    [
        'key' => '/^news\/page-([0-9]*)\/?$/',
        'vars' => 'page',
        'path' => 'news',
    ],
    // новость
    [
        'key' => '/^news\/([^\/]*)-([0-9]*)\/?$/',
        'vars' => 'alias, id',
        'path' => 'news/category/view',
    ],    
];