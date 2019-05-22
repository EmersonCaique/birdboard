<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = auth()->user()->projects;
        return view('pages.project.index', compact('projects'));
    }

    public function store(){
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        $project = new Project;
        $project->fill(request()->all());
        auth()->user()->projects()->save($project);

        return redirect('project');
    }

    public function show(Project $project){
        abort_if(!auth()->user()->projects->contains($project), 403);
        return view('pages.project.show', compact('project'));
    }

}
