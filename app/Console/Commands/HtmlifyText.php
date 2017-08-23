<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;

class HtmlifyText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'htmlify:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert text to html';

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
        foreach (Content::whereNull('html')->get() as $content) {
            $content->fill(
                ['html' => Content::htmlify(($content->text))]
            )->save();
            $this->info('…');
        }
    }
}
