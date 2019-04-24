<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitESearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $bar = $this->output->createProgressBar(\App\Models\Paragraph::count() + \App\Models\Book::count() + \App\Models\User::count() + 1);

        ini_set('memory_limit', '-1');
        $params = ['body' => []];
        $i = 0;
        $count = \App\Models\Paragraph::count();
        foreach ($array = \App\Models\Paragraph::get() as $key => $shit) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'paragraphs',
                    '_type' => get_class($shit),
                    '_id' => $shit->id,
                ]
            ];

            $params['body'][] = $shit;

            // Every 1000 documents stop and send the bulk request
            if ($i % 1000 == 0 || $i == $count - 1) {
                $responses = \Elasticsearch::bulk($params);

                // erase the old bulk request
                $params = ['body' => []];

                // unset the bulk response when you are done to save memory
                unset($responses);
            }
            $i++;
            $bar->advance();
        }
        $this->info(' Done');

        $params = ['body' => []];
        $i = 0;
        $count = \App\Models\Book::count();
        foreach ($array = \App\Models\Book::get() as $key => $shit) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'books',
                    '_type' => get_class($shit),
                    '_id' => $shit->id,
                ]
            ];

            $params['body'][] = $shit;

            // Every 1000 documents stop and send the bulk request
            if ($i % 1000 == 0 || $i == $count - 1) {
                $responses = \Elasticsearch::bulk($params);

                // erase the old bulk request
                $params = ['body' => []];

                // unset the bulk response when you are done to save memory
                unset($responses);
            }
            $i++;
            $bar->advance();
        }
        $this->info(' Done');

        $params = ['body' => []];
        $i = 0;
        $count = \App\Models\User::count();
        foreach ($array = \App\Models\User::get() as $key => $shit) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'users',
                    '_type' => get_class($shit),
                    '_id' => $shit->id,
                ]
            ];

            $params['body'][] = $shit;

            // Every 1000 documents stop and send the bulk request
            if ($i % 1000 == 0 || $i == $count - 1) {
                $responses = \Elasticsearch::bulk($params);

                // erase the old bulk request
                $params = ['body' => []];

                // unset the bulk response when you are done to save memory
                unset($responses);
            }
            $i++;
            $bar->advance();
        }
        $bar->advance();
        $this->info(' Done');
    }
}
