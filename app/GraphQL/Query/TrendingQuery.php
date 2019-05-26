<?php

namespace App\GraphQL\Query;

use Cache;
use App\Models\Page;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TrendingQuery extends Query
{
    protected $attributes = [
        'name' => 'TrendingQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return GraphQL::paginate('Page');
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if (Cache::has('trending')) {
            return Cache::get('trending');
        }

        $trending = Page::where('content', '!=', ':empty')
            ->inRandomOrder()
            ->take(11)
            ->paginate();

        Cache::put('trending', $trending, 60 * 60); // 1 hour
        return $trending;
    }
}
