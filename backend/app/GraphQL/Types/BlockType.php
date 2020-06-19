<?php

namespace App\GraphQL\Types;

use App\Block;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BlockType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Block',
        'description'   => 'A Block',
        'model'         => Block::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the block'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'The content of block'
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of block'
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'The type of block'
            ],
            'order' => [
                'type' => Type::int(),
                'description' => 'The order of block'
            ],
            'page' => [
                'type' => GraphQL::type('page'),
                'description' => 'The page of block',
            ],
            'page_no' => [
                'type' => Type::int(),
                'description' => 'The page number',
                'resolve' => function ($root, $args) {
                    return (int) ($root->page->book->pages
                        ->where('parent_id', $root->page->parent_id)
                        ->where('id', '<=', $root->page->id)
                        ->count() / 10) + 1;
                }
            ]
        ];
    }
}
