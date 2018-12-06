<?php

namespace App\GraphQL\Query;

use Cache;
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
        $key = 'users:' . $args['sticky'] ? 'featured' : 'latest';

        // Get users from list cache and return
        // if (Redis::exists('users:' .  $key)) {
        //     $users = collect(Redis::lrange('users:' .  $key, 0, -1));
        //     return $users->map(function ($user) {
        //         return json_decode($user);
        //     })->first();
        // }
        // @todo: use LIST
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        // Get users from DB
        if(isset($args['sticky'])) {
            $users = UserRepository::featuredAuthors();
        } else {
            $users = UserRepository::latest();
        }

        // Put users in cache and return
        // $users->map(function ($user) use ($key) {
        //     Redis::rpush('users:' . $key, $user);
        // });
        $users = $users->get();
        Cache::put($key, $users, 60);
        return $users;
    }
}
