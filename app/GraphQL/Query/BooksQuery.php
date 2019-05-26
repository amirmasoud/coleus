<?php

namespace App\GraphQL\Query;

use App\Models\Book;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BooksQuery extends Query
{
    protected $attributes = [
        'name' => 'BooksQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return GraphQL::paginate('Book');
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return Book::paginate();
    }
}
