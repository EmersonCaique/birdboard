<?php

namespace App\Observers;

use App\Activity;

class ProjectObserver
{
    public function created($project)
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => 'created',
        ]);
    }

    public function updated($project)
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => 'updated',
        ]);
    }
}
