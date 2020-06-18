<?php

namespace App\GraphQL\Types;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'User',
        'description'   => 'A user',
        'model'         => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user'
            ],
            'username' => [
                'type' => Type::string(),
                'description' => 'The username of user'
            ],
            'original' => [
                'type' => Type::string(),
                'description' => 'The original image of user'
            ],
            'medium' => [
                'type' => Type::string(),
                'description' => 'The medium image of user'
            ],
            'small' => [
                'type' => Type::string(),
                'description' => 'The small image of user'
            ],
            'xsmall' => [
                'type' => Type::string(),
                'description' => 'The xsmall image of user'
            ],
            'thumbnail' => [
                'type' => Type::string(),
                'description' => 'The thumbnail image of user'
            ],
            'placeholder' => [
                'type' => Type::string(),
                'description' => 'The placeholder image of user'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of user'
            ],
            'totalBooks' => [
                'type' => Type::int(),
                'description' => 'Total number of books of user',
                'resolve' => function ($root, $args) {
                    return $root->books()->count();
                }
            ],
            'books' => [
                'type' => Type::listOf(GraphQL::type('book')),
                'description' => 'The user\'s books',
                'args' => [
                    'limit' => [
                        'type' => Type::int(),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return $root->books()
                        ->limit($args['limit'] ?? INF)
                        ->get();
                }
            ]
        ];
    }
}
