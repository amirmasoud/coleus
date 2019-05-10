<?php

namespace App\GraphQL\Query;

use Cache;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Facades\App\Repositories\BookRepository;

class BookQuery extends Query
{
    protected $attributes = [
        'name' => 'BookQuery',
        'description' => 'A query to fetch book'
    ];

    public function type()
    {
        return Type::nonNull(GraphQL::type('Book'));
    }

    public function args()
    {
        return [
            'slug' => ['name' => 'slug', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(1);

        if (isset($args['slug'])) {
            $key = 'book:' . md5(serialize($args + $fields));
            if (Cache::has($key)) {
                return Cache::get($key);
            }

            $book = BookRepository::findBySlug($args['slug']);

            foreach ($fields as $field => $keys) {
                if ($field === 'pages') {
                    $book->with(['pages' => function($query) {
                        $query->orderBy('id', 'asc');
                    }]);
                }

                if ($field === 'collaborators') {
                    $book->with('collaborators');
                }
            }

            $book = $book->firstOrFail();
            Cache::put($key, $book, 60);
            return $book;
        }

        return null;
    }
}
