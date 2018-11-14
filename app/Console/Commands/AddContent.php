<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:content
                            {path : The path to dataset}
                            {book : The book ID to content add to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add content to a book';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Book::find($this->argument('book'))->pages()->count() || $this->confirm('Do you wish to continue?')) {
            $guy = Storage::disk('dataset')->allFiles($this->argument('path'));
            sort($guy);
            foreach ($guy as $poem) {
                if (Str::endsWith($poem, '.json')) {
                    $file = json_decode(Storage::disk('dataset')->get($poem));
                    $title = '';
                    $content = '';
                    foreach ($file->text as $key => $part) {
                        if (! $key) { // First item - Generate title of page
                            $title = $part->m1;
                        }
                        $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m1 . '</p>';
                        $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m2 . '</p>';
                    }
                    \App\Models\Book::find($this->argument('book'))
                        ->pages()
                        ->create([
                            'title' => $title,
                            'content' => $content
                        ]);
                }
            }
            $this->info('Data added to book.');
        } else {
            $this->error('Operation cancelled!');
        }
    }
}
