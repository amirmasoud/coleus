<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SearchBookType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SearchBookType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'title' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The title of the book'
            ],
            'description' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The description of description'
            ],
            'slug' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The slug of book'
            ]
        ];
    }
}
