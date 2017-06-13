<?php

namespace App;

trait RecordsActivity
{
    // for any trait the model uses
    // boot + name of trait runs model events automagically
    protected static function bootRecordsActivity() {
        if (auth()->guest()) return;

        foreach (static::getActivityToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
           $model->activity()->delete();
        });
    }

    protected static function getActivityToRecord() {
        return ['created'];
    }

    protected function recordActivity($event){
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity() {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event) {
        $type = strtolower(( new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}