<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function creating_a_project_generate_an_activity()
    {
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activity);

        $activity = $project->activity[0];

        $this->assertEquals('created', $activity->description);
    }

    /** @test */

    public function updating_a_project_generate_an_activity()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->user)->patch($project->path(), ['title' => 'new'])->assertRedirect($project->path());

        $this->assertCount(2,$project->activity);
        $activity = Project::first()->activity->last();

        $this->assertEquals('updated', $activity->description);
    }
    
    /** @test */

    public function creating_a_project_task_generate_a_project_activity()
    {
        $project = ProjectFactory::create();
        $project->addTask('hello world');
        $this->assertCount(2,$project->activity);
    }
    /** @test */

    public function completing_a_project_task_generate_a_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->user)->patch($project->tasks[0]->path(), [
            'completed' => true,
            'body' => 'changed'
        ]);

        $this->assertCount(3,$project->activity);
    }
}
