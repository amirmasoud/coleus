<?php

namespace App\GraphQL\Type\Auth;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ResetPasswordType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ResetPasswordType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'status' => [
                'type' => Type::string(),
                'description' => 'Get the response for a successful password reset link'
            ]
        ];
    }
}
