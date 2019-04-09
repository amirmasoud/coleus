<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use App\Http\Repositories\Auth\AuthRepository;

class PasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'PasswordMutation',
        'description' => 'A mutation to change user password.'
    ];

    public function type()
    {
        return GraphQL::type('Status');
    }

    public function args()
    {
        return [
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'password_confirmation' => [
                'name' => 'password_confirmation',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return (new AuthRepository())->updatePassword(new Request($args));
    }
}
