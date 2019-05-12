<?php

namespace App\GraphQL\Type\Search;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AutoCompleteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AutoCompleteType',
        'description' => 'A type that shows autocomplete search items.'
    ];

    public function fields()
    {
        return [
            'paragraphs' => [
                'args' => \Facades\App\GraphQL\Type\ParagraphType::fields(),
                'type' => Type::listOf(GraphQL::type('Paragraph')),
                'description' => 'The result\'s paragraphs'
            ],
            'books' => [
                'args' => \Facades\App\GraphQL\Type\BookType::fields(),
                'type' => Type::listOf(GraphQL::type('Book')),
                'description' => 'The result\'s books'
            ],
            'users' => [
                'args' => \Facades\App\GraphQL\Type\UserType::fields(),
                'type' => Type::listOf(GraphQL::type('User')),
                'description' => 'The result\'s users'
            ],
        ];
    }
}
