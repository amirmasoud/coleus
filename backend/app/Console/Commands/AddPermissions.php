<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class AddPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:permissions {resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permissions for given resource, added permissions includes browse, view, create, update, delete, restore and force delete';

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
        $this->comment("Adding permissions for {$this->argument('resource')}...");
        Permission::firstOrCreate(['name' => 'browse ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'view ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'create ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'update ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'delete ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'restore ' . $this->argument('resource')]);
        Permission::firstOrCreate(['name' => 'force delete ' . $this->argument('resource')]);
        $this->info("7 new permissions for {$this->argument('resource')} has been added: browse, view, create, update, delete, restore and force delete.");
    }
}
