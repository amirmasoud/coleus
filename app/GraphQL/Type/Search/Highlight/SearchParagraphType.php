<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SearchParagraphType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SearchParagraphType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'content' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The content of the paragraph'
            ],
        ];
    }
}
