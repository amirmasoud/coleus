<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;

class ParagraphType extends BaseType
{
    protected $attributes = [
        'name' => 'ParagraphTypeType',
        'description' => 'A type that '
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
            ],
            'highlight' => [
                'type' => Type::listOf(GraphQL::type('ParagraphHighlight')),
                'description' => 'The paragraph search highlight'
            ],
        ];
    }
}
