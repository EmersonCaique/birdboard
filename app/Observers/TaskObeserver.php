<?php

namespace App\Observers;

class TaskObeserver
{
    public function created($task)
    {
        $task->project->recordActivity('created_task');
    }

    public function updated($task)
    {
        $task->project->recordActivity('updated_task');
    }
}
