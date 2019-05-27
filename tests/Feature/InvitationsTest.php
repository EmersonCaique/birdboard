<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();
        $project->invite($user = factory('App\User')->create());

        $this->auth($user);
        $this->post(action('ProjectTaskController@store', $project), $task = ['body' => 'New Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
