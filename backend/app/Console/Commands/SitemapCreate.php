<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SitemapCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new sitemap.xml';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function url(...$params)
    {
        return '<url>
            <loc>' . config('app.front') . '/' . implode('/', $params) . '</loc>
        </url>
        ';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = [];
        $pages = [];
        foreach (User::get() as $user) {
            $users[] = $this->url($user['username']);
            foreach ($user->books()->get() as $book) {
                foreach ($book->pages()->whereNotNull('parent_id')->get() as $page) {
                    $pages[] = $this->url($user['username'], $book['slug'], $page->parent_id, $page->id);
                }
            }
        }

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
            xmlns:xhtml="http://www.w3.org/1999/xhtml"
            xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"
            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
            xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">'
            . implode('', $users) .
            implode('', $pages) .
            '</urlset>';

        Storage::put('sitemap.xml', $sitemap, 'public');
        $this->info(Storage::url('public/sitemap.xml'));
    }
}
