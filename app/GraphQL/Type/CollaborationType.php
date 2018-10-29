<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class CollaborationType extends BaseType
{
    protected $attributes = [
        'name' => 'CollaborationType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the collaboration'
            ],
            'collaboration_role' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The title of the collaboration role'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user'
            ],
            'website' => [
                'type' => Type::string(),
                'description' => 'The website of user'
            ],
            'bio' => [
                'type' => Type::string(),
                'description' => 'The bio of user'
            ],
            'username' => [
                'type' => Type::string(),
                'description' => 'The username of user'
            ],
            'locked' => [
                'type' => Type::boolean(),
                'description' => 'The locked status of user'
            ],
            'photo_url' => [
                'type' => Type::string(),
                'description' => 'The Gravatar photo of user'
            ],
            'thumbnail' => [
                'type' => Type::string(),
                'description' => 'The thumbnail photo of user'
            ],
            'xsmall' => [
                'type' => Type::string(),
                'description' => 'The X-small photo of user'
            ],
            'small' => [
                'type' => Type::string(),
                'description' => 'The small photo of user'
            ],
            'medium' => [
                'type' => Type::string(),
                'description' => 'The medium photo of user'
            ]
        ];
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    function resolveCollaborationRoleField($root, $args)
    {
        return $root->pivot->collaboration_roles;
    }
}
