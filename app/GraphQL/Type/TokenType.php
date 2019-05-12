<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TokenType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'taken' => [
                'type' => Type::Boolean(),
                'description' => 'Set to true if an EmailTokenException has been thrown'
            ],
            'token' => [
                'type' => Type::String(),
                'description' => 'The token of the user'
            ],
            'token_type' => [
                'type' => Type::String(),
                'description' => 'The token_type of the user'
            ],
            'expires_in' => [
                'type' => Type::Int(),
                'description' => 'The expires_in of the user'
            ]
        ];
    }
}
