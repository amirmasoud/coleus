<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Facades\App\Repositories\Auth\LoginRepository;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LoginMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('Token');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return LoginRepository::login(new Request($args));
    }
}
