<?php
/**
 * Created by PhpStorm.
 * User: Mer
 * Date: 07/07/2020
 * Time: 08:55
 */

namespace Tests\Setup;


use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{

    protected $count = 0;
    protected $user = null;
    public function withTasks($count)
    {
        $this->count = $count;

        return $this;
    }

    public function ownedBy($user) {
        $this->user = $user;
        return $this;
    }

    public function create() {

        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class),
        ]);

        factory(Task::class, $this->count)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

}