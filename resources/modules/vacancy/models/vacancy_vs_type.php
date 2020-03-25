<?php

return [
    'id' => '05',
    'type' => 'pivot',
    'table' => 'vacancy_vs_type',
    'fields' => [
        'vacancy_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
        'type_id' => [
            'type' => 'integer',
            'migration' => [
                'foreign' => ['vacancy_types', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],        
    ], 
    'migration' => [
        'name' => 'VacancyVsType',
        'primary' => ['vacancy_id', 'type_id'],
    ],
];