<?php

namespace App\GraphQL\Types;

use App\Book;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BookType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Book',
        'description'   => 'A book',
        'model'         => Book::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the book'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of book'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The slug of book'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of book'
            ],
            'original' => [
                'type' => Type::string(),
                'description' => 'The original image of book'
            ],
            'medium' => [
                'type' => Type::string(),
                'description' => 'The medium image of book'
            ],
            'small' => [
                'type' => Type::string(),
                'description' => 'The small image of book'
            ],
            'xsmall' => [
                'type' => Type::string(),
                'description' => 'The xsmall image of book'
            ],
            'thumbnail' => [
                'type' => Type::string(),
                'description' => 'The thumbnail image of book'
            ],
            'placeholder' => [
                'type' => Type::string(),
                'description' => 'The placeholder image of book'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of book'
            ],
            'users' => [
                'type' => Type::listOf(GraphQL::type('user')),
                'description' => 'The user book',
            ],
            'pages' => [
                'type' => Type::listOf(GraphQL::type('page')),
                'description' => 'The book pages',
                'args' => [
                    'order_by' => [
                        'type' => Type::string(),
                    ],
                    'limit' => [
                        'type' => Type::int(),
                    ],
                    'parent_id' => [
                        'type' => Type::string(),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return $root->pages()
                        ->when($args['parent_id'] == 'not_null', function ($query) {
                            return $query->whereNotNull('parent_id');
                        })
                        ->orderBy('id', $args['order_by'] ?? 'desc')
                        ->limit($args['limit'] ?? 15)
                        ->get();
                }
            ]
        ];
    }
}
