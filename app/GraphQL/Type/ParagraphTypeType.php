<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ParagraphTypeType extends BaseType
{
    protected $attributes = [
        'name' => 'ParagraphTypeType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the paragraph'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'The content of paragraph'
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Type of paragraph'
            ]
        ];
    }
}
