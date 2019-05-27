<?php

namespace App\Traits;

use App\Activity;

trait RecordActivity
{
    public $old = [];

    public static function bootRecordActivity()
    {
        foreach (static::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->old = $model->getOriginal();
                });
            }
        }
    }

    public function activityDescription($description)
    {
        return "{$description}_".strtolower(class_basename($this));
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->changes(),
            'project_id' => class_basename($this) == 'Project' ? $this->id : $this->project_id,
        ]);
    }

    private function changes()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(
                    array_diff($this->old, $this->getAttributes()), 'updated_at'
                ),
                'after' => array_except(
                    $this->getChanges(), 'updated_at'
                ),
            ];
        }
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        } else {
            return ['created', 'updated', 'deleted'];
        }
    }
}
