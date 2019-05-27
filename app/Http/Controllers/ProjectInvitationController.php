<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Http\Requests\ProjectInvitaionRequest;

class ProjectInvitationController extends Controller
{
    public function store(Project $project, ProjectInvitaionRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);

        return redirect(route('project.show', ['project' => $project->id]));
    }
}
