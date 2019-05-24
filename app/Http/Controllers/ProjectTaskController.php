<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskRequest;

class ProjectTaskController extends Controller
{
    public function store(Project $project, TaskRequest $request)
    {
        abort_if(auth()->user()->isNot($project->owner), 403);

        $project->addTask(request('body'));

        return redirect()->route('project.show', ['project' => $project->id]);
    }

    public function update(Project $project, Task $task, TaskRequest $request)
    {
        $this->authorize('update', $task->project);

        if (request()->has('completed')) {
            $task->complete();
        }

        $task->update([
            'body' => request('body'),
        ]);

        return redirect()->route('project.show', ['project' => $project->id]);
    }
}
