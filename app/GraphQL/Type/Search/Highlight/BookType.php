<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class BookType extends BaseType
{
    protected $attributes = [
        'name' => 'BookType',
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
            ],
            'collaborators' => [
                'args' => \Facades\App\GraphQL\Type\CollaborationType::fields(),
                'type' => Type::listOf(GraphQL::type('Collaboration')),
                'description' => 'Collaborations on the book'
            ],
        ];
    }
}
