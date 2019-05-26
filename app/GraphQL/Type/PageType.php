<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PageType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the page'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the page'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'The content of page'
            ],
            'is_header' => [
                'type' => Type::boolean(),
                'description' => 'Is page a header with no content'
            ],
            'next' => [
                'type' => Type::string(),
                'description' => 'Next sibling of the page'
            ],
            'prev' => [
                'type' => Type::string(),
                'description' => 'Previous sibling of the page'
            ],
            'next_title' => [
                'type' => Type::string(),
                'description' => 'Next sibling title of the page'
            ],
            'prev_title' => [
                'type' => Type::string(),
                'description' => 'Previous sibling title of the page'
            ],
            'book' => [
                'type' => GraphQL::type('Book'),
                'description' => 'Book that this page belongs to'
            ],
        ];
    }
}
