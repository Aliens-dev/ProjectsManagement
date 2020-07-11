<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{

    use RecordActivity;

    protected $guarded = [];

    protected static $activityEvents = ['created', 'updated'];

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

    public function addTask($body) {
        return $this->tasks()->create(compact('body'));
    }

    public function activity() {
        return $this->hasMany('App\Activity')->latest();
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'project_members')->withTimestamps();
    }

    //    public function recordActivity($type) {
////        Activity::create([
////            'project_id' => $this->id,
////            'description' => $type,
////        ]);
//        $this->activity()->create([
//            'description' => $type,
//            'changes' =>$this->projectChanges($type)
//        ]);
//    }

//    public function projectChanges($type) {
//        if( $type !== 'updated') {
//            return;
//        }
//        return [
//            'before' => Arr::except(array_diff($this->old, $this->getAttributes()),'updated_at'),
//            'after' => Arr::except(array_diff($this->getAttributes(), $this->old),'updated_at'),
//        ];
//    }



}