<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Http\Repositories\Auth\OAuthRepository;

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

    public function resolve($root, $args)
    {
        return (new OAuthRepository())->redirectToProvider($args['driver']);
    }
}
