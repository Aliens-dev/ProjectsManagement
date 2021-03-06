<?php

namespace Tests\Unit;



use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_belongs_to_a_project()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $task = $project->addTask('hello');

        $this->assertInstanceOf(Project::class, $task->project);

    }

    /** @test */

    public function it_has_a_path()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $task = $project->addTask('hello');


        $this->assertEquals($project->path(). '/tasks/' . $task->id, $task->path());

    }

    /** @test */

    public function it_can_be_completed()
    {
        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);
        $task->complete();

        $this->assertTrue($task->completed);
    }
    /** @test */

    public function it_can_be_uncompleted()
    {
        $task = factory('App\Task')->create(['completed' => true]);

        $this->assertTrue($task->completed);
        $task->incomplete();

        $this->assertFalse($task->completed);
    }
}
