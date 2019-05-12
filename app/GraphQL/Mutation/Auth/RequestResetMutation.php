<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class RequestResetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Request reset password',
        'description' => 'Request new password via email address.'
    ];

    public function type()
    {
        return GraphQL::type('Reset');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return (new \App\Http\Controllers\Auth\ForgotPasswordController())
            ->sendResetLinkEmail(new Request($args));
    }
}
