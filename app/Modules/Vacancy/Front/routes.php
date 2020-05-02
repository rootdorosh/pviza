<?php 

return [
    // jobs pager
    [
        'key' => '/^jobs\/page-([0-9]*)\/?$/',
        'vars' => 'page',
        'path' => 'jobs',
    ],
    // jobs location page pager
    [
        'key' => '/^job-location\/([^\/]*)\/page-([0-9]*)\/?$/',
        'vars' => 'alias,page',
        'path' => 'jobs/location',
    ],
    // jobs location page
    [
        'key' => '/^job-location\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'jobs/location',
    ],
    // jobs type page pager
    [
        'key' => '/^job-type\/([^\/]*)\/page-([0-9]*)\/?$/',
        'vars' => 'alias,page',
        'path' => 'jobs/type',
    ],
    // jobs type page
    [
        'key' => '/^job-type\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'jobs/type',
    ],
    // jobs category page pager
    [
        'key' => '/^job-category\/([^\/]*)\/page-([0-9]*)\/?$/',
        'vars' => 'alias,page',
        'path' => 'jobs/category',
    ],
    // jobs category page
    [
        'key' => '/^job-category\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'jobs/category',
    ],
    // jobs vacancy page
    [
        'key' => '/^jobs\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'jobs/vacancy',
    ],
];