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
            ->expectsOutput('4 roles added/found: subscriber, writer, publisher and admin.');

        $this->assertDatabaseHas('roles', ['name' => 'subscriber']);
        $this->assertDatabaseHas('roles', ['name' => 'writer']);
        $this->assertDatabaseHas('roles', ['name' => 'publisher']);
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }
}
