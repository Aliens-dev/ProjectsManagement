<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
//        $this->signIn();
//        $project  = factory(Project::class)->create(['owner_id'=> auth()->id() ]);

        // new Syntax!
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $attributes = ['body' => 'Test Task'];
        $this->post($project->path()."/tasks",$attributes);
        $this->assertDatabaseHas('tasks',$attributes);
        $this->get($project->path())->assertSee('Test Task');
    }

    /** @test */

    public function only_project_owner_can_add_tasks()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->post($project->path(). '/tasks', ['body' => 'hello world'])->assertStatus(403);
        $this->assertDatabaseMissing('projects',['body'=> 'hello world']);
    }

    /** @test */

    public function only_project_owner_can_update_a_task()
    {
//        $this->signIn();
//        $project = factory('App\Project')->create();
//        $task = $project->addTask('welcome');

        $this->signIn();
        $project = ProjectFactory::create();
        $task = $project->addTask('welcome');
        $this->assertDatabaseHas('tasks', ['body'=> 'welcome', 'completed'=> false]);

        $this->patch($task->path(), ['body' => 'updated', 'completed'=> true])->assertStatus(403);
        $this->assertDatabaseMissing('projects',['body'=> 'updated', 'completed' => true]);
    }


    /** @test */
    public function a_task_requires_a_body()
    {
//        $this->signIn();
//        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->post($project->path() . '/tasks', ['body' => ''])->assertSessionHasErrors('body');
    }
    
    
    /** @test */

    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();

        //$task = $project->addTask('test task');

        $this->actingAs($project->user)->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true,
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', ['body'=> 'changed', 'completed'=> true]);
    }
    /** @test */

    public function a_task_can_be_uncompleted()
    {
        $this->withoutExceptionHandling();
        
        $project = ProjectFactory::withTasks(1)->create();

        //$task = $project->addTask('test task');

        $this->actingAs($project->user)->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => false,
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', ['body'=> 'changed', 'completed'=> false]);
    }
}
