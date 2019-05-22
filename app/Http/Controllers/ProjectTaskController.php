<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskStoreRequest;

class ProjectTaskController extends Controller
{
    public function store(Project $project, TaskStoreRequest $request){
        $project->addTask(request('body'));

        return redirect()->route('project.show', ['project' => $project->id]);
    }
}
