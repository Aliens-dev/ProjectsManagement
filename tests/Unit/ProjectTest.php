<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
