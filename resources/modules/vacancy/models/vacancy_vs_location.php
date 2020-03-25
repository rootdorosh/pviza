<?php

return [
    'id' => '05',
    'type' => 'pivot',
    'table' => 'vacancy_vs_location',
    'fields' => [
        'vacancy_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
        'location_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy_locations', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
    ], 
    'migration' => [
        'name' => 'VacancyVsLocation',
        'primary' => ['vacancy_id', 'location_id'],
    ],
];