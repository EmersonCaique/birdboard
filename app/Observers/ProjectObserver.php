<?php

namespace App\Observers;

class ProjectObserver
{
    public function created($project)
    {
        $project->recordActivity('created');
    }

    public function updated($project)
    {
        $project->recordActivity('updated');
    }
}
