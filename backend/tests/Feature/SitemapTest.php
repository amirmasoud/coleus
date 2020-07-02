<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use DOMDocument;
use App\User;
use App\Book;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test command output.
     *
     * @return void
     */
    public function testCommand()
    {
        $this->artisan('sitemap:create')
            ->expectsOutput(Storage::url('public/sitemap.xml'))
            ->assertExitCode(0);
    }

    /**
     * Test existence and validity of XML file.
     *
     * @return void
     */
    public function testFile()
    {
        // Create entries
        factory(User::class, 30)
            ->create()
            ->each(function ($user) {
                foreach (range(0, 10) as $i) {
                    $user->books()->save(factory(Book::class)->make());
                }
            });

        // Test if file created
        Artisan::call('sitemap:create');
        $this->assertTrue(Storage::exists('sitemap.xml'));

        // Test if file is not empty
        $content = Storage::get('sitemap.xml');
        $this->assertFalse(trim($content) == '');

        // Test if file is a valid XML file
        libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($content);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        $this->assertTrue(empty($errors));
    }
}
