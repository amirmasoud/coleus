<?php

namespace App\GraphQL\Query;

use Cache;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
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

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(1);

        if (isset($args['id'])) {
            $key = 'page:' . md5(serialize($args + $fields));
            if (Cache::has($key)) {
                return Cache::get($key);
            }

            $page = PageRepository::findById($args['id']);

            $page = $page->firstOrFail();
            Cache::put($key, $page, 60);
            return $page;
        }

        return null;
    }
}
