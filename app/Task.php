<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected static $activityEvents = ['created', 'deleted'];

    protected $casts= ["completed" => "boolean"];

    protected $touches = ['project'];

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('complete_task');
    }
    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incomplete_task');
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function path() {
        return $this->project->path() . '/tasks/' . $this->id;
    }




//    public function recordActivity($description) {
//        $this->activity()->create([
//            'description' => $description,
//            'project_id' => $this->project_id,
//        ]);
//    }



}
