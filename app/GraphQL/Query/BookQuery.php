<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
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

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(1);

        $book = null;

        if(isset($args['slug'])) {
            $book = BookRepository::findBySlug($args['slug']);

            foreach ( $fields as $field => $keys) {
                if ($field === 'pages') {
                    $book->with('pages');
                }
            }

            return $book->firstOrFail();
        }

        return null;
    }
}