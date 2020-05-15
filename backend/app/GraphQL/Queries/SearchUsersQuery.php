<?php

namespace App\GraphQL\Queries;

use Closure;
use App\User;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class SearchUsersQuery extends Query
{
    protected $attributes = [
        'name' => 'Users query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    public function args(): array
    {
        return [
            'q' => ['name' => 'q', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (isset($args['q'])) {
            return User::search($args['q'])->get();
        }

        return [];
    }
}
