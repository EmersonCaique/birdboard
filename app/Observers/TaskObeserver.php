<?php

namespace App\Observers;

class TaskObeserver
{
    public function created($task)
    {
        $task->project->recordActivity('created_task');
    }

    public function deleted($task)
    {
        $task->project->recordActivity('deleted_task');
    }

    // public function updated($task)
    // {
    //     $task->project->recordActivity('updated_task');
    // }
}
