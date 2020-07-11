<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $anotherUser = factory('App\User')->create();
        $project->invite($anotherUser);
        $this->actingAs($anotherUser)->post($project->path() . '/tasks', ['body' => 'hello']);

        $this->assertDatabaseHas('tasks', ['body' => 'hello']);

    }

}
