<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Facades\App\Repositories\UserRepository;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'UserQuery',
        'description' => 'A single user returned by username.'
    ];

    public function type()
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'username' => ['name' => 'username', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(5);

        $user = null;

        if(isset($args['username'])) {
            $user = UserRepository::findByUsername($args['username']);
        }

        foreach ($fields as $field => $keys) {
            if ($field === 'books') {
                $user->with('books');
            }

            if ($field === 'following_count') {
                $user->withCount('followings');
            }

            if ($field === 'followers_count') {
                $user->withCount('followers');
            }

            if ($field === 'books_count') {
                $user->withCount('books');
            }
        }

        return $user->firstOrFail();
    }
}