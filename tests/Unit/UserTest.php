<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    /** @test */

    public function it_has_accessible_projects()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $project = ProjectFactory::create();

        ProjectFactory::ownedBy($user)->create();

        $project->invite($user);
        $this->assertCount(2,$user->accessibleProjects());
    }
}
