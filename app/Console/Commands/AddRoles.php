<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add default roles to database (if not added already).';

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
        $this->comment('Adding default roles...');
        Role::firstOrNew(['name' => 'subscriber']);
        Role::firstOrNew(['name' => 'writer']);
        Role::firstOrNew(['name' => 'publisher']);
        $this->info('3 roles added/found: subscriber, writer and publisher.');
    }
}
