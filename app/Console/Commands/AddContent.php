<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Page;
use App\Models\Sort;
use App\Models\Paragraph;
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
                            {--T|title= : The title of the content}
                            {--R|refresh : Refresh book\'s content before import}
                            {--C|count : Count title on indexing}
                            {--P|persian : Persian numbers}
                            {--H|header=* : Subheader titles}
                            {--A|append : Append m1 to titles}
                            {--D|delimiter= : Delimiter for append and title, default is ": "}';

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
        $delimiter = $this->option('delimiter') ?: ': ';

        // Remove all book content before adding new content.
        if ($this->option('refresh')) {
            $this->info('Refreshing book' . PHP_EOL);
            Sort::where('scope', 'book#' . $this->argument('book'))
                ->where('sortable_type', '<>', 'App\Models\Book')
                ->delete();
            $ids = array_map(function($item) {
                return $item['id'];
            }, Book::find($this->argument('book'))->pages()->get(['id'])->toArray());

            Paragraph::whereIn('page_id', $ids)->delete();
            Book::find($this->argument('book'))->pages()->delete();
        }

        $person = Storage::disk('dataset')->allFiles($this->argument('path'));

        $bar = $this->output->createProgressBar(count($person) + 1);

        sort($person, SORT_NATURAL);

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

        // Insert content
        $i = 1;
        foreach ($person as $index => $poem) {
            if (Str::endsWith($poem, '.json')) {
                $file = json_decode(Storage::disk('dataset')->get($poem));
                $title = '';
                $content = '';
                foreach ($file->text as $key => $part) {
                    if (! $key) { // First item
                        if (!$this->option('title') && property_exists($part, 'm1') && !$this->option('header')) { // First m2
                            $title = $part->m1;
                        } else { // Custom title
                            if ($this->option('header') && @isset($this->option('header')[$index])) {
                                $title = $this->option('header')[$index];
                            } else {
                                if ($this->option('persian')) {
                                    $str = $i;
                                    $western_persian = array('0','1','2','3','4','5','6','7','8','9');
                                    $eastern_persian = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

                                    $str = str_replace($western_persian, $eastern_persian, $str);
                                    $i++;
                                }
                                $title = $this->option('count')
                                            ? $this->option('title') . ' ' . ($this->option('persian') ? $str : $i++)
                                            : $this->option('title');
                            }

                            if ($this->option('append') && property_exists($part, 'm1')) {
                                $title .= $delimiter . $part->m1;
                            }
                        }
                    }

                    if (property_exists($part, 'm1') && property_exists($part, 'm2')) {
                        $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m1 . '</p>';
                        $content .= '<p class="col-12 col-md-6" style="text-align: right;">' . $part->m2 . '</p>';
                    }

                    if (property_exists($part, 't1') && property_exists($part, 't2')) {
                        $content .= '<p class="t col-12 col-md-6" style="text-align: right;">' . $part->t1 . '</p>';
                        $content .= '<p class="t col-12 col-md-6" style="text-align: right;">' . $part->t2 . '</p>';
                    }

                    if (property_exists($part, 'p')) {
                        $content .= '<p class="t col-12" style="text-align: right;">' . $part->p . '</p>';
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

        $this->info('    Data added to book.');
    }
}
