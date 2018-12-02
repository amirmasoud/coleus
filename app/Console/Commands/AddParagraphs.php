<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;

class AddParagraphs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:paragraphs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add paragraph from pages table.';

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

        $bar = $this->output->createProgressBar(Page::count());
        $bar->start();

        foreach (Page::get() as $page) {
            $chunks = explode('</p>', $page->content);
            foreach ($chunks as $chunk) {
                if (starts_with($chunk, '<p class="col-12 col-md-6" style="text-align: right;">')) {
                    $paragraph = str_replace('<p class="col-12 col-md-6" style="text-align: right;">', '', $chunk);
                    $page->paragraphs()->create([
                        'content' => $paragraph,
                        'type' => 'App\Types\TowColumns',
                    ]);
                } else if (starts_with($chunk, '<p class="t col-12 col-md-6" style="text-align: right;">')) {
                    $paragraph = str_replace('<p class="t col-12 col-md-6" style="text-align: right;">', '', $chunk);
                    $page->paragraphs()->create([
                        'content' => $paragraph,
                        'type' => 'App\Types\TowColumns',
                    ]);
                } else if (starts_with($chunk, '<p class="t col-12" style="text-align: right;">')) {
                    $paragraph = str_replace('<p class="t col-12" style="text-align: right;">', '', $chunk);
                    $page->paragraphs()->create([
                        'content' => $paragraph,
                        'type' => 'App\Types\OneColumn',
                    ]);
                } else {
                    $page->paragraphs()->create([
                        'content' => $chunk,
                        'type' => 'App\Types\Plain',
                    ]);
                }
            }
            $bar->advance();
        }

        $bar->finish();
    }
}
