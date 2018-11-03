<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Facades\App\Repositories\UserRepository;

class UsersQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'UsersQuery',
        'description' => 'List of users filtered by featured users and letest users.'
    ];

    /**
     * Type of the query.
     *
     * @return GraphQL\Type\Definition\ListOfType|null
     */
    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    /**
     * Available argument to query on.
     *
     * @return array
     */
    public function args()
    {
        return [
            'sticky' => ['name' => 'sticky', 'type' => Type::boolean()],
        ];
    }

    /**
     * @param  $root
     * @param  $args
     * @param  $context
     * @param  \GraphQL\Type\Definition\ResolveInfo $info
     * @return mixed
     */
    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if(isset($args['sticky'])) {
            $users = UserRepository::featuredAuthors();
        } else {
            $users = UserRepository::latest();
        }

        return $users->get();
    }
}
