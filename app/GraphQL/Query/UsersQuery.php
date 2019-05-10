<?php

namespace App\GraphQL\Query;

use Cache;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
    public function resolve($root, $args)
    {
        if(isset($args['sticky'])) {
            return UserRepository::featuredAuthors()->get();
        } else {
            return UserRepository::latest()->get();
        }
    }
}
