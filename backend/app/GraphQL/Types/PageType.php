<?php

namespace App\GraphQL\Types;

use App\Page;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
            'parent_id' => [
                'type' => Type::int(),
                'description' => 'The parent ID of page'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of page'
            ],
            'book' => [
                'type' => GraphQL::type('book'),
                'description' => 'The page books',
            ],
            'page_no' => [
                'type' => Type::int(),
                'description' => 'The page number',
                'resolve' => function ($root, $args) {
                    return (int) ($root->book->pages
                        ->where('parent_id', $root->parent_id)
                        ->where('id', '<=', $root->id)
                        ->count() / 10) + 1;
                }
            ]
        ];
    }
}
