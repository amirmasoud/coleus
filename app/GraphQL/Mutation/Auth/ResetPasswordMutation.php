<?php

namespace App\GraphQL\Mutation\Auth;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;

class ResetPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ResetPasswordMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return Type::listOf(Type::string());
    }

    public function args()
    {
        return [
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return [];
    }
}
