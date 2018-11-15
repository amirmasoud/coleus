<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Page;
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
                            {book : The book ID to content add to}
                            {parent? : The parent of the content}
                            {--R|refresh : Refresh book\'s content before import}';

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
        ini_set('memory_limit', '-1');

        if ($this->option('refresh')) {
            Book::find($this->argument('book'))->pages()->delete();
        }

        if (!Book::find($this->argument('book'))->pages()->count() || $this->confirm('Do you wish to continue?')) {
            $guy = Storage::disk('dataset')->allFiles($this->argument('path'));

            $bar = $this->output->createProgressBar(count($guy) + 1);

            sort($guy, SORT_NATURAL);

            $bar->start();

            if ($this->argument('parent')) {
                $parent = Book::find($this->argument('book'))
                    ->pages()
                    ->create([
                        'title' => $this->argument('parent'),
                        'content' => ':empty'
                    ]);
            }

            $bar->advance();

            foreach ($guy as $poem) {
                if (Str::endsWith($poem, '.json')) {
                    $file = json_decode(Storage::disk('dataset')->get($poem));
                    $title = '';
                    $content = '';
                    foreach ($file->text as $key => $part) {
                        if (! $key && property_exists($part, 'm1')) { // First item - Generate title of page
                            $title = $part->m1;
                        }

                        if (property_exists($part, 'm1') && property_exists($part, 'm2')) {
                            $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m1 . '</p>';
                            $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m2 . '</p>';
                        }

                        if (property_exists($part, 't1') && property_exists($part, 't2')) {
                            $content .= '<p class="t col-12 col-md-6" style="text-align: right;">' . $part->t1 . '</p>';
                            $content .= '<p class="t col-12 col-md-6" style="text-align: right;">' . $part->t2 . '</p>';
                        }
                    }

                    Book::find($this->argument('book'))
                        ->pages()
                        ->create([
                            'title'   => $title,
                            'content' => $content,
                            'parent' => $this->argument('parent') ? $parent : null
                        ]);
                }
                $bar->advance();
            }

            $bar->finish();

            $this->info('Data added to book.');
        } else {
            $this->error('Operation cancelled!');
        }
    }
}
