<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get();

        return view('pages.project.index', compact('projects'));
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'required',
            'notes' => 'nullable',
        ]);

        $project = new Project();
        $project->fill(request()->all());
        auth()->user()->projects()->save($project);

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

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $error = $this->validate(request(), [
            'notes' => 'min:3',
        ]);

        $project->update(request()->all());

        return redirect()->route('project.show', ['project' => $project->id]);
    }
}
