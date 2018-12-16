<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class TokenType extends BaseType
{
    protected $attributes = [
        'name' => 'TokenType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'token' => [
                'type' => Type::String(),
                'description' => 'The token of the user'
            ],
            'token_type' => [
                'type' => Type::string(),
                'description' => 'The token_type of the user'
            ],
            'expires_in' => [
                'type' => Type::Int(),
                'description' => 'The expires_in of the user'
            ]
        ];
    }
}
