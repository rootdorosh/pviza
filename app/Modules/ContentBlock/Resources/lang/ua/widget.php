<?php 

return [
    'name' => 'Content Blocks',
    'actions' => [
        'index' => 'Show Content Block',
    ],
    'templates' => [
        'empty' 		=> 'Only content',
        'title_content' => 'Title + Content',        
    ],
    'attributes' => [
        'template' => 'Template',
        'block_id' => 'Block',        
    ],
];