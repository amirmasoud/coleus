<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class OAuthType extends BaseType
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
