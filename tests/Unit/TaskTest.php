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

}
