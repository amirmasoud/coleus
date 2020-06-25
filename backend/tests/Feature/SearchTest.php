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
        $response = $this->get('/api/search?q=test');

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
    }

    /**
     * Test searching book.
     *
     * @return void
     */
    public function testBookSearch()
    {
    }

    /**
     * Test searching page.
     *
     * @return void
     */
    public function testPageSearch()
    {
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
