<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use \App\Exceptions\Auth\LoginFailed;
use Facades\App\Repositories\Auth\AuthRepository;

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
                'type' => Type::string()
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    public function resolve($root, $args)
    {
        try {
            return AuthRepository::login($args);
        } catch(LoginFailed $e) {
            throw new LoginFailed('اطلاعات ورود اشتباه است.');
        }
    }
}
