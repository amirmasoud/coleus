<?php

namespace App\GraphQL\Type;

use GraphQL;
use App\Models\Book;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BookType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'BookType',
        'description' => 'A book type',
        'model'       => Book::class,
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
            'start' => [
                'type' => Type::Int(),
                'description' => 'The start of the book'
            ],
            'highlight' => [
                'type' => Type::listOf(GraphQL::type('BookHighlight')),
                'description' => 'The book search highlight'
            ]
        ];
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    function resolveStartField($root, $args)
    {
        $start = \App\Models\Book::find($root['id'])->pages()
                    ->where('content', '!=', ':empty')
                    ->orderBy('id', 'asc')->first();
        return $start ? $start->id : 0;
    }
}
