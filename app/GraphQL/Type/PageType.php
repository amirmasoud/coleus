<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class PageType extends BaseType
{
    protected $attributes = [
        'name' => 'PageType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the page'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the page'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'The content of page'
            ]
        ];
    }
}
