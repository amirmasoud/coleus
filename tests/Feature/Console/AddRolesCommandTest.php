<?php

namespace Tests\Feature\Console;

use Tests\TestCase;

class AddRolesCommandTest extends TestCase
{
    /**
     * Test adding default roles.
     *
     * @test
     * @group  commands/addRoles
     * @return void
     */
    public function it_add_default_roles(): void
    {
        $this->artisan('add:roles')
            ->expectsOutput('Adding default roles...')
            ->expectsOutput('3 roles added/found: subscriber, writer and publisher.');

        $this->assertDatabaseHas('roles', ['name' => 'subscriber']);
        $this->assertDatabaseHas('roles', ['name' => 'writer']);
        $this->assertDatabaseHas('roles', ['name' => 'publisher']);
    }
}
