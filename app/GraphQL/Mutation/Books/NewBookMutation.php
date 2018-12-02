<?php

namespace App\GraphQL\Mutation\Books;

use GraphQL;
use App\Models\Book;
use App\GraphQL\Type\Upload;
use App\Models\CollaborationRole;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class NewBookMutation extends Mutation
{
    protected $attributes = [
        'name' => 'NewBookMutation',
        'description' => 'Add a new book.'
    ];

    public function type()
    {
        return GraphQL::type('Book');
    }

    public function args()
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'cover' => [
                'name' => 'cover',
                'type' => Type::nonNull(Upload::type()),
                'rules' => ['image']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $book = Book::create($args);

        $book->clearMediaCollection('books/cover');
        $book->addMedia(request()->file()[0])->toMediaCollection('books/cover');

        request()->user()->books()->save($book,
            [
                'collaboration_role_id' => CollaborationRole::whereTitle('Author')->first()->id
            ]
        );
    }
}
