<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Facades\App\Repositories\PageRepository;

class PageQuery extends Query
{
    protected $attributes = [
        'name' => 'PageQuery',
        'description' => 'A query to get page'
    ];

    public function type()
    {
        return Type::nonNull(GraphQL::type('Page'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(1);

        $page = null;

        if(isset($args['id'])) {
            $page = PageRepository::findById($args['id']);
        }

        return $page->firstOrFail();
    }
}
