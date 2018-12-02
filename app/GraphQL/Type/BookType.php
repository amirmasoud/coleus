<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class BookType extends BaseType
{
    protected $attributes = [
        'name' => 'BookType',
        'description' => 'A book type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the book'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the book'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the book'
            ],
            'cover' => [
                'type' => Type::string(),
                'description' => 'The cover of the book'
            ],
            'placeholder' => [
                'type' => Type::string(),
                'description' => 'The placeholder of the book'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The slug of the book'
            ],
            'collaborators' => [
                'args' => \Facades\App\GraphQL\Type\CollaborationType::fields(),
                'type' => Type::listOf(GraphQL::type('Collaboration')),
                'description' => 'Collaborations on the book'
            ],
            'pages' => [
                'args' => \Facades\App\GraphQL\Type\PageType::fields(),
                'type' => Type::listOf(GraphQL::type('Page')),
                'description' => 'The book\'s pages'
            ],
        ];
    }
}
