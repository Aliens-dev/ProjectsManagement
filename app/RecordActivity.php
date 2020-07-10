<?php

namespace App;

use Illuminate\Support\Arr;

trait RecordActivity
{

    public $old = [];

    public static function bootRecordActivity() {

        static::updating(function ($model) {
            $model->old = $model->getOriginal();
        });

        foreach (self::$activityEvents as $event) {
            static::$event(function($model) use($event) {
                $model->recordActivity("{$event}_". strtolower(class_basename($model)));
            });
        }


    }

    public function recordActivity($description) {
        $this->activity()->create([
            'description' => $description,
            'project_id' => $this->project_id,
            'changes' =>$this->projectChanges($description)
        ]);
    }

    public function projectChanges($type) {
        if( $type !== 'updated') {
            return;
        }
        return [
            'before' => Arr::except(array_diff($this->old, $this->getAttributes()),'updated_at'),
            'after' => Arr::except(array_diff($this->getAttributes(), $this->old),'updated_at'),
        ];
    }

}