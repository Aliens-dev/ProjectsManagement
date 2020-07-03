<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Project;
use Tests\TestCase;

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
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }


    /** @test */
    public function  a_user_can_create_a_project()
    {

        $this->actingAs(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */

    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        // create a user and login..
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */

    public function an_authenticated_user_cannot_view_projects_of_others()
    {

        // create a user and login..
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();

        $response = $this->get($project->path());

        $response->assertStatus(403);


    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // acts like a logged in user
        $this->actingAs(factory('App\User')->create());
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
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);
        $response = $this->post('/projects', $attributes);
        $response->assertSessionHasErrors('description');
    }


}
