<?php

namespace App\GraphQL\Type\Search;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class AutoCompleteType extends BaseType
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
                'type' => Type::listOf(GraphQL::type('Page')),
                'description' => 'The result\'s paragraphs'
            ],
            'books' => [
                'args' => \Facades\App\GraphQL\Type\BookType::fields(),
                'type' => Type::listOf(GraphQL::type('Page')),
                'description' => 'The result\'s books'
            ],
            'users' => [
                'args' => \Facades\App\GraphQL\Type\UserType::fields(),
                'type' => Type::listOf(GraphQL::type('Page')),
                'description' => 'The result\'s users'
            ],
        ];
    }
}
