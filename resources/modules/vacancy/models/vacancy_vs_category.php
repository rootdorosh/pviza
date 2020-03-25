<?php

return [
    'id' => '05',
    'type' => 'pivot',
    'table' => 'vacancy_vs_category',
    'fields' => [
        'vacancy_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
        'category_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy_categories', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
    ], 
    'migration' => [
        'name' => 'VacancyVsCategory',
        'primary' => ['vacancy_id', 'category_id'],
    ],
];