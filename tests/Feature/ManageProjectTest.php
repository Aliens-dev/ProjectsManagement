<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;

class ManageProjectTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    public function  a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        //$this->actingAs(factory('App\User')->create());
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = $this->attributes();

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes'])
            ->assertSee($attributes['title']);
    }

    /** @test */

    public function a_user_cannot_update_a_project_of_others()
    {
        //$this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path() , ['notes' => ''])->assertStatus(403);

        $this->assertDatabaseMissing('projects', ['notes'=> 'new Note']);

    }

    /** @test */
    public function a_user_can_update_their_project()
    {
        $this->withoutExceptionHandling();

        //$this->actingAs(factory('App\User')->create());
        $project = ProjectFactory::create();
        $attributes = $this->attributes();

        $this->actingAs($project->user)->patch($project->path(), $attributes)->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function a_user_can_update_general_notes()
    {
        $this->withoutExceptionHandling();

        //$this->actingAs(factory('App\User')->create());
        $project = ProjectFactory::create();
        $attributes = $this->attributes();

        $this->actingAs($project->user)->patch($project->path(), ['notes' => $attributes['notes']])->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', ['notes' => $attributes['notes']]);

    }
    /** @test */

    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        // create a user and login..
        //$this->be(factory('App\User')->create());

//        $this->signIn();
//
//        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */

    public function a_guest_cannot_delete_any_project()
    {
        $project = ProjectFactory::create();

        $response = $this->delete($project->path());

        $response->assertRedirect('login');

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->assertNotNull($project->fresh());

    }
    
    /** @test */

    public function a_user_can_see_all_projects_they_have_been_invited_to()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $project = ProjectFactory::create();

        $project->invite($user);

        $this->get('/projects')->assertSee($project->title);


    }
    /** @test */

    public function a_user_can_delete_their_projects()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $response = $this->actingAs($project->user)->delete($project->path());

        $response->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);

        $this->assertNull($project->fresh());

    }

    /** @test */

    public function a_user_cannot_delete_projects_of_others()
    {

        $user = $this->signIn();
        $project = ProjectFactory::create();

        $response = $this->actingAs($user)->delete($project->path());

        $response->assertStatus(403);

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->assertNotNull($project->fresh());

    }

    /** @test */

    public function an_authenticated_user_cannot_view_projects_of_others()
    {

        // create a user and login..
        //$this->be(factory('App\User')->create());
        $this->signIn();

        $project = factory('App\Project')->create();

        $response = $this->get($project->path());

        $response->assertStatus(403);


    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // acts like a logged in user
        //$this->actingAs(factory('App\User')->create());
        $this->signIn();

        // raw => returns array doesn't save in the database!
        // make : returns object => doesn't save in database;
        // create : saves in database!
        $attributes = factory('App\Project')->raw(['title' => '']);
        $response = $this->post('/projects', $attributes);
        $response->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_project_requires_a_description()
    {
        //$this->actingAs(factory('App\User')->create());

        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);
        $response = $this->post('/projects', $attributes);
        $response->assertSessionHasErrors('description');
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'notes' => "some Note"
        ];
        return $attributes;
    }


}
