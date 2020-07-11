<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
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

        $this->assertEquals('created_project', $activity->description);

        $activity = $project->activity->last();
        $this->assertNull($activity->changes);
    }

    /** @test */

    public function updating_a_project_generate_an_activity()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;
        $this->actingAs($project->user)->patch($project->path(), ['title' => 'new Title'])->assertRedirect($project->path());

        $this->assertCount(2,$project->activity);

        $activity = $project->activity->last();

        $expected = [
            'before' => [
                'title' => $originalTitle
            ],
            'after' => [
                'title' => 'new Title',
            ]
        ];
        $this->assertEquals($expected, $activity->changes);
    }
    
    /** @test */

    public function creating_a_project_task_generate_a_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('hello world');

        $this->assertCount(2,$project->activity);

        $activity = $project->activity->last();

        $this->assertEquals('created_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);


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

        $activity = $project->activity->last();

        $this->assertEquals('complete_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
    }
    /** @test */

    public function incompleting_a_project_task_generate_a_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->user)->patch($project->tasks[0]->path(), [
            'completed' => true,
            'body' => 'changed'
        ]);

        $this->assertCount(3,$project->activity);

        $this->actingAs($project->user)->patch($project->tasks[0]->path(), [
            'completed' => false,
            'body' => 'changed'
        ]);

        $this->assertCount(4,$project->fresh()->activity);

        $activity = $project->fresh()->activity->last();

        $this->assertEquals('incomplete_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
    }
    
    /** @test */

    public function deleting_a_task_generate_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
    
}
