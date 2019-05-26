<?php

namespace App\Observers;

class ProjectObserver
{
    public function created($project)
    {
        $project->recordActivity('created');
    }

    public function updating($project)
    {
        $project->old = $project->getOriginal();
    }

    public function updated($project)
    {
        $project->recordActivity('updated');
    }
}
