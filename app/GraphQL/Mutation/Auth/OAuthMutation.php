<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class OAuthMutation extends Mutation
{
    protected $attributes = [
        'name' => 'OAuthMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('OAuth');
    }

    public function args()
    {
        return [
            'driver' => [
                'name' => 'driver',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return (new \App\Http\Controllers\Auth\OAuthController())
            ->redirectToProvider($args['driver']);
    }
}