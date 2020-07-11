<?php

namespace App;

use Illuminate\Support\Arr;

trait RecordActivity
{

    public $old = [];

    public static function bootRecordActivity() {

        foreach (static::recordableEvents() as $event) {
            static::$event(function($model) use($event) {
                $model->recordActivity("{$event}_". strtolower(class_basename($model)));
            });
        }
        static::updating(function ($model) {
            $model->old = $model->getOriginal();
        });
    }

    public function recordActivity($description) {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner_id,
            'description' => $description,
            'changes' =>$this->projectChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }


    public function projectChanges() {
        if($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()),'updated_at'),
                'after' => Arr::except(array_diff($this->getAttributes(), $this->old),'updated_at'),
            ];
        }
    }
    public static function recordableEvents() {
        if(isset(static::$activityEvents)) {
            return static::$activityEvents;
        }
        return ['created','updated'];
    }
    public function activity() {
        return $this->morphMany(Activity::class,'subject');
    }
}