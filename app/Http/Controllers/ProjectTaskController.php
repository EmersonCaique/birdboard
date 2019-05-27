<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskRequest;

class ProjectTaskController extends Controller
{
    public function store(Project $project, TaskRequest $request)
    {
    $this->authorize('update', $project);

        $project->addTask(request('body'));

        return redirect()->route('project.show', ['project' => $project->id]);
    }

    public function update(Project $project, Task $task, TaskRequest $request)
    {
        $this->authorize('update', $task->project);

        $method = request('completed') ? 'complete' : 'incomplete';
        $task->$method();

        $task->update(['body' => request('body')]);

        return redirect()->route('project.show', ['project' => $project->id]);
    }
}
