<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Facades\App\Repositories\SearchRepository;

class SearchQuery extends Query
{
    protected $attributes = [
        'name' => 'SearchQuery',
        'description' => 'An autocomplete result.'
    ];

    public function type()
    {
        return Type::nonNull(GraphQL::type('Search'));
    }

    public function args()
    {
        return [
            'query' => ['name' => 'query', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(4);

        if (isset($args['query'])) {
            return SearchRepository::autocomplete($args['query']);
        }

        return null;
    }
}
