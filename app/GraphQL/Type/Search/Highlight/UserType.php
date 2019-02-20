<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The name of the user'
            ],
            'username' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The username of user'
            ],
            'bio' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The bio of user'
            ]
        ];
    }
}
