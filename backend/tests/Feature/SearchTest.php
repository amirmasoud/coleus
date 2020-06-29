<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Book;
use App\Page;
use App\Block;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test search status.
     *
     * @return void
     */
    public function testStatus()
    {
        $response = $this->get('/graphql');

        $response->assertStatus(200);
    }

    /**
     * Test searching user.
     *
     * @return void
     */
    public function testUserSearch()
    {
        $user = factory(User::class)->create();
        $user->update(['name' => 'Test User']);
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('GET', '/graphql', [
            'query' => 'query search($q: String) {SearchUsers(q: $q) {name}}',
            'variables' => '{"q":"Test"}'
        ]);
        $response->assertStatus(200)->assertExactJson([
            'data' => [
                'SearchUsers' => [
                    ["name" => "Test User"]
                ]
            ]
        ]);
    }

    /**
     * Test searching book.
     *
     * @return void
     */
    public function testBookSearch()
    {
        $user = factory(User::class)->create();
        $user->books()->createMany(
            factory(Book::class, 1)->make()->toArray()
        );
        $book = Book::first();
        $book->update(['title' => 'Test Book']);
        $this->assertDatabaseHas('books', ['id' => $book->id]);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('GET', '/graphql', [
            'query' => 'query search($q: String) {SearchBooks(q: $q) {title}}',
            'variables' => '{"q":"Test"}'
        ]);
        $response->assertStatus(200)->assertExactJson([
            'data' => [
                'SearchBooks' => [
                    ["title" => "Test Book"]
                ]
            ]
        ]);
    }

    /**
     * Test searching page.
     *
     * @return void
     */
    public function testPageSearch()
    {
        $user = factory(User::class)->create();
        $user->books()->createMany(
            factory(Book::class, 1)->make()->toArray()
        );
        $book = Book::first();
        $this->assertDatabaseHas('books', ['id' => $book->id]);

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('GET', '/graphql', [
            'query' => 'query search($q: String) {SearchBooks(q: $q) {title}}',
            'variables' => '{"q":"Test"}'
        ]);
        $response->assertStatus(200)->assertExactJson([
            'data' => [
                'SearchBooks' => [
                    ["title" => "Test Book"]
                ]
            ]
        ]);
    }

    /**
     * Test searching block.
     *
     * @return void
     */
    public function testBlockSearch()
    {
    }
}
