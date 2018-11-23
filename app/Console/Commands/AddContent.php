<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Page;
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
                            {title? : The title of the content}
                            {--R|refresh : Refresh book\'s content before import}
                            {--C|count : Count title on indexing}
                            {--P|persian : Persian numbers}';

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
            $this->info('Refreshing book' . PHP_EOL);
            $ids = array_map(function($item) {
                return $item['id'];
            }, Book::find($this->argument('book'))->pages()->get(['id'])->toArray());

            Paragraph::whereIn('page_id', $ids)->delete();
            Book::find($this->argument('book'))->pages()->delete();
        }

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

        $i = 1;
        foreach ($guy as $poem) {
            if (Str::endsWith($poem, '.json')) {
                $file = json_decode(Storage::disk('dataset')->get($poem));
                $title = '';
                $content = '';
                foreach ($file->text as $key => $part) {
                    if (! $key) { // First item
                        if (!$this->argument('title') && property_exists($part, 'm1')) { // First m2
                            $title = $part->m1;
                        } else { // Custom title
                            if ($this->option('persian')) {
                                $str = $i;
                                $western_persian = array('0','1','2','3','4','5','6','7','8','9');
                                $eastern_persian = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

                                $str = str_replace($western_persian, $eastern_persian, $str);
                                $i++;
                            }
                            $title = $this->option('count')
                                        ? $this->argument('title') . ' ' . ($this->option('persian') ? $str : $i++)
                                        : $this->argument('title');
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
