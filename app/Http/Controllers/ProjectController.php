<?php

namespace App\Http\Controllers;

use App\Project;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('pages.project.index', compact('projects'));
    }

    public function store(ProjectRequest $request)
    {
        $project = new Project();
        $project->fill($request->all());
        auth()->user()->projects()->save($project);

        if ($request->has('tasks')) {
            foreach ($request->tasks as $task) {
                $project->addTask($task['body']);
            }
        }

        if ($request->wantsJson()) {
            return ['message' => route('project.show', ['project' => $project->id])];
        }

        return redirect('project');
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('pages.project.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('pages.project.edit', compact('project'));
    }

    public function create()
    {
        return view('pages.project.create');
    }

    public function update(Project $project, ProjectRequest $request)
    {
        $this->authorize('update', $project);

        $project->update($request->all());

        return redirect()->route('project.show', ['project' => $project->id]);
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);
        $project->delete();

        return redirect('project');
    }
}
