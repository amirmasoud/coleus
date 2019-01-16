<?php

namespace App\GraphQL\Mutation\Auth;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class CallbackMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CallbackMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('Token');
    }

    public function args()
    {
        return [
            'driver' => [
                'name' => 'driver',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'code' => [
                'name' => 'code',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return (new \App\Http\Controllers\Auth\OAuthController())
            ->handleProviderCallback($args['driver'], $args['code']);
    }
}
