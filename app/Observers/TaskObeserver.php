<?php

namespace App\Observers;

class TaskObeserver
{
    public function created($task)
    {
        $task->recordActivity('created_task');
    }

    public function deleted($task)
    {
        $task->recordActivity('deleted_task');
    }
}
