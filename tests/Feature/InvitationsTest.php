<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $userToInvite = factory('App\User')->create();

        $this->auth(factory('App\User')->create());
        $reponse = $this->post("project/{$project->id}/invitations", [
            'email' => $userToInvite->email,
        ]);

        $reponse->assertStatus(403);
    }

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $userToInvite = factory('App\User')->create();

        $this->auth($project->owner);
        $reponse = $this->post("project/{$project->id}/invitations", [
            'email' => $userToInvite->email,
        ]);

        $reponse->assertRedirect("project/$project->id");

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function the_invited_email_address_must_be_a_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $this->auth($project->owner);
        $reponse = $this->post("project/{$project->id}/invitations", [
            'email' => 'error@mail.com',
        ]);

        $reponse->assertSessionHasErrors([
            'email' => 'The user you inviting must have a Birdboard account',
        ]);
    }

    /** @test */
    public function invited_users_may_updated_projects_details()
    {
        $project = ProjectFactory::create();
        $project->invite($user = factory('App\User')->create());

        $this->auth($user);
        $this->post(action('ProjectTaskController@store', $project), $task = ['body' => 'New Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
