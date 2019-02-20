<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ParagraphType extends BaseType
{
    protected $attributes = [
        'name' => 'ParagraphType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'content' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The content of the paragraph'
            ]
        ];
    }
}
