<?php

namespace App\GraphQL\Mutation\Users;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class FollowMutation extends Mutation
{
    protected $attributes = [
        'name' => 'FollowMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'user' => [
                'name' => 'user',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        if (auth()->check()) {
            auth()->user()->toggleFollow($args['user']);
        }

        return auth()->user();
    }
}
