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
            'page' => [
                'args' => \Facades\App\GraphQL\Type\PageType::fields(),
                'type' => Type::listOf(GraphQL::type('Page')),
                'description' => 'The paragraph\'s page'
            ],
            'book' => [
                'args' => \Facades\App\GraphQL\Type\BookType::fields(),
                'type' => Type::listOf(GraphQL::type('Book')),
                'description' => 'The paragraph\'s book'
            ],
            'collaborators' => [
                'args' => \Facades\App\GraphQL\Type\CollaborationType::fields(),
                'type' => Type::listOf(GraphQL::type('Collaboration')),
                'description' => 'Collaborations on the book'
            ],
        ];
    }
}
