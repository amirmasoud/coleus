<?php

namespace App\GraphQL\Query;

use Cache;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
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
        return GraphQL::paginate('User');
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
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(5);

        if(isset($args['sticky'])) {
            $users = UserRepository::featuredAuthors();
        } else {
            $users = UserRepository::latest();
        }

        foreach ($fields['data'] as $field => $keys) {
            if ($field === 'books') {
                $users->with('books');
            }
        }

        return $users->paginate();
    }
}
