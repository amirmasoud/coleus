<?php

namespace App\GraphQL\Types;

use App\Block;
use GraphQL\Type\Definition\Type;
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
        ];
    }
}
