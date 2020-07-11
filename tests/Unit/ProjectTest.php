<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function it_has_a_path()
    {
        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/'. $project->id,$project->path());
    }

    /** @test */
    public function it_belongs_to_a_user() {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User',$project->user);
        $this->assertEquals($project->owner_id, $project->user->id);
    }

    /** @test */

    public function it_can_add_tasks()
    {
        $project = factory('App\Project')->create();
        $task = $project->addTask('Test Task');
        $this->assertCount(1,$project->tasks);
        $this->assertTrue($project->tasks->contains($task));

    }

    /** @test */

    public function it_can_invite_users()
    {
        $project = ProjectFactory::create();

        $project->invite($user = factory(User::class)->create());

        $this->assertTrue($project->members->contains($user));
    }


}
