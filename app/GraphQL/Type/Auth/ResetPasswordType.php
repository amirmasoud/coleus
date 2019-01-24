<?php

namespace App\GraphQL\Type\Auth;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class ResetPasswordType extends BaseType
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
            ],
            // 'email' => [
            //     'type' => Type::string(),
            //     'description' => 'Get the response for a failed password reset link'
            // ]
        ];
    }
}
