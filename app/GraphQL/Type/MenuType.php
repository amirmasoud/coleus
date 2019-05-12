<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MenuType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MenuType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the menu'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the menu'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of the menu'
            ],
        ];
    }
}
