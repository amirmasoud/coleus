<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class OAuthType extends GraphQLType
{
    protected $attributes = [
        'name' => 'OAuthType',
        'description' => 'An OAuth provider authentication page url'
    ];

    public function fields()
    {
        return [
            'url' => [
                'type' => Type::String(),
                'description' => 'Authentication page url'
            ]
        ];
    }
}
