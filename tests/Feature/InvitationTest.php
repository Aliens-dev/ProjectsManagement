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

    public function a_project_owner_can_invite_users()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $anotherUser = factory('App\User')->create();

        $this->actingAs($project->user)->post($project->path() . '/invitations/', [
            'email' => $anotherUser->email,
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($anotherUser));

    }

    /** @test */

    public function invited_users_can_update_a_project_details()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $anotherUser = factory('App\User')->create();
        $project->invite($anotherUser);
        $this->actingAs($project->user)->post($project->path() . '/tasks', ['body' => 'hello']);

        $this->assertDatabaseHas('tasks', ['body' => 'hello']);

    }
    
    /** @test */

    public function the_invited_email_must_be_a_valid_registred_user()
    {

        $email = 'test@test.com';

        $project = ProjectFactory::withTasks(1)->create();

        $anotherUser = factory('App\User')->create();

        $this->actingAs($project->user)->post($project->path() . '/invitations/', [
            'email' => $email,
        ])->assertSessionHasErrors('email');

        $this->assertFalse($project->members->contains($anotherUser));


    }
    /** @test */
    public function non_owners_cannot_invite_users()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $this->actingAs($user)->post($project->path() . '/invitations', [
            'email' => $user->email,
        ])->assertStatus(403);

        $this->assertFalse($project->members->contains($user));
    }


    /** @test */

    public function sending_invitation_requires_an_email()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->user)->post($project->path() . '/invitations')->assertSessionHasErrors('email');

    }
}
