<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    protected $casts= [
        "completed" => "boolean"
    ];
    protected $touches = ['project'];

    protected static function boot()
    {
        parent::boot();
        static::created(function($task) {
            $task->project->recordActivity('created_task');
        });
        static::updated(function($task) {
            if(!$task->completed) return;
            $task->project->recordActivity('updated_task');
        });
    }

    public function complete()
    {
        $this->update(['completed' => true]);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function path() {
        return $this->project->path() . '/tasks/' . $this->id;
    }
}
