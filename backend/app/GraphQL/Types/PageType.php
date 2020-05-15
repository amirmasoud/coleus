<?php

namespace App\GraphQL\Types;

use App\Page;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PageType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Page',
        'description'   => 'A Page',
        'model'         => Page::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the page'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of page'
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of page'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of page'
            ],
        ];
    }
}
