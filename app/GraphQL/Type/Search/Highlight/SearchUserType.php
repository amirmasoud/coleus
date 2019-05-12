<?php

namespace App\GraphQL\Type\Search\Highlight;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SearchUserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SearchUserType',
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
