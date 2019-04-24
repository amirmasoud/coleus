<?php

namespace App\GraphQL\Type\Common;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;

class StatusType extends BaseType
{
    protected $attributes = [
        'name' => 'StatusType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'status' => [
                'type' => Type::string(),
                'description' => 'Get the response for a successful password reset link'
            ]
        ];
    }
}
