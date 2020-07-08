<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];


    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function user() {
        return $this->belongsTo('App\User','owner_id');
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function recordActivity($type) {
        Activity::create([
            'project_id' => $this->id,
            'description' => $type,
        ]);
    }
    
    public function addTask($body) {
        return $this->tasks()->create(compact('body'));
    }

    public function activity() {
        return $this->hasMany('App\Activity');
    }

}