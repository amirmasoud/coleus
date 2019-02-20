<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;

class UserType extends BaseType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A user'
    ];

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user'
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
            ],
            'placeholder' => [
                'type' => Type::string(),
                'description' => 'The placeholder photo of user'
            ],
            'sticky' => [
                'type' => Type::boolean(),
                'description' => 'The user is sticky'
            ],
            'followers_count' => [
                'type' => Type::int(),
                'description' => 'The user followers count'
            ],
            'following_count' => [
                'type' => Type::int(),
                'description' => 'The user following count'
            ],
            'books_count' => [
                'type' => Type::int(),
                'description' => 'The user books count'
            ],
            'books' => [
                'args' => \Facades\App\GraphQL\Type\BookType::fields(),
                'type' => Type::listOf(GraphQL::type('Book')),
                'description' => 'The user\'s books'
            ],
            'is_following' => [
                'type' => Type::boolean(),
                'description' => 'The user is following the profile'
            ],
            'highlight' => [
                'type' => Type::listOf(GraphQL::type('UserHighlight')),
                'description' => 'The user search highlight'
            ],
        ];
    }

    /**
     * @param  $root
     * @param  $args
     * @return string
     */
    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    protected function resolveStickyField($root, $args)
    {
        return $root->sticks()->exists();
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    function resolveFollowingCountField($root, $args)
    {
        return $root->followings()->count();
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    function resolveFollowersCountField($root, $args)
    {
        return $root->followers()->count();
    }

    /**
     * @param  $root
     * @param  $args
     * @return mixed
     */
    function resolveIsFollowingField($root, $args)
    {
        return auth()->check() ? auth()->user()->isFollowing($root) : false;
    }
}
