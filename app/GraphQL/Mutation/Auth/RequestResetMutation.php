<?php

namespace App\GraphQL\Mutation\Auth;

use GraphQL;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

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

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return (new \App\Http\Controllers\Auth\ForgotPasswordController())
            ->sendResetLinkEmail(new Request($args));
    }
}
