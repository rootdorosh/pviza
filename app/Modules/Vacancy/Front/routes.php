<?php 

return [
    // service page
    [
        'key' => '/^services\/([^\/]*)\/?$/',
        'vars' => 'alias',
        'path' => 'services/view',
    ],
];