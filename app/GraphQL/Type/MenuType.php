<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class MenuType extends BaseType
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
