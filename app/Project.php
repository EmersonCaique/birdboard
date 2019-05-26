<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'notes'];
    public $old = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $description == 'updated' ? $this->changes() : null,
        ]);
    }

    private function changes()
    {
        return  [
            'before' => array_diff($this->old, $this->getAttributes()),
            'after' => array_diff($this->getAttributes(), $this->old),
        ];
    }
}
