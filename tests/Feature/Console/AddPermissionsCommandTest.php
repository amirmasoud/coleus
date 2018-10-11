<?php

namespace Tests\Feature\Console;

use Tests\TestCase;

class AddPermissionsCommandTest extends TestCase
{
    /**
     * Test adding permissions for resource.
     *
     * @test
     * @group  commands/addPermissions
     * @return void
     */
    public function it_add_permissions_for_resource()
    {
        $this->artisan('add:permissions', ['resource' => 'posts'])
            ->expectsOutput('Adding permissions for posts...')
            ->expectsOutput('7 new permissions for posts has been added: browse, view, create, update, delete, restore and force delete.');

        $this->assertDatabaseHas('permissions', ['name' => 'browse posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'view posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'create posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'update posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'delete posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'restore posts']);
        $this->assertDatabaseHas('permissions', ['name' => 'force delete posts']);
    }
}
