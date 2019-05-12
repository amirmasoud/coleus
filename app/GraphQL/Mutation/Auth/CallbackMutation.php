<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Http\Repositories\Auth\OAuthRepository;

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

    public function resolve($root, $args)
    {
        return (new OAuthRepository())
            ->handleProviderCallback($args['driver'], $args['code']);
    }
}
