<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function guest_cannot_view_projects()
    {
        $this->get('project')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guest_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create(['owner_id' => factory('App\User')->create()]);
        $this->get(route('project.show', ['project' => $project->id]))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guest_cannot_craete_a_project()
    {
        $project = factory('App\Project')->raw();
        $this->get('project', $project)->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->auth();

        $project = factory('App\Project')->raw();
        $request = $this->post('project', $project);
        $request->assertStatus(302);

        $this->assertDatabaseHas('projects', $project);
    }

    /**
     * @test
     */
    public function a_user_can_see_all_projects_they_have_been_invitedto_on_their_dashboar()
    {
        $this->withoutExceptionHandling();
        $project = tap(ProjectFactory::create())->invite($this->auth());
        $this->get('project')->assertSee($project->title);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();

        $projectEdited = factory('App\Project')->make();

        $request = $this->put(route('project.update', ['project' => $project->id]), [
            'notes' => 'note updated',
            'description' => 'description updated',
            'title' => 'title updated',
        ]);
        $request->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'notes' => 'note updated',
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();
        $request = $this->delete("project/$project->id");
        $request
            ->assertStatus(302)
            ->assertRedirect('/project');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /**
     * @test
     */
    public function unauthorized_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();
        $this
            ->delete("project/$project->id")
            ->assertRedirect('/login');

        $user = $this->auth();
        $this
            ->delete("project/$project->id")
            ->assertStatus(403);

        $project->invite($user);

        $this
            ->actingAs($user)
            ->delete("project/$project->id")
            ->assertStatus(403);

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project_notes()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();

        $request = $this->put(route('project.update', ['project' => $project->id]), [
            'notes' => 'note updated',
        ]);
        $request->assertStatus(302);

        $this->assertDatabaseHas('projects', [
            'notes' => 'note updated',
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        $this->auth();

        $project = factory('App\Project')->make();
        auth()->user()->projects()->save($project);

        $response = $this->get(route('project.show', ['project' => $project->id]));
        $response->assertSee('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->auth();

        $project = factory('App\Project')->raw(['title' => '']);
        $request = $this->post('project', $project);
        $request->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        // $this->actingAs(factory('App\User')->create());
        $this->auth();

        $project = factory('App\Project')->raw(['description' => '']);
        $request = $this->post('project', $project);
        $request->assertSessionHasErrors('description');
    }

    /** @test */
    public function tasks_can_be_include_as_part_new_project_creation()
    {
        $this->auth();

        $attributes = factory('App\Project')->raw();
        $attributes['tasks'] = [
            ['body' => 'task 1'],
            ['body' => 'task 2'],
        ];
        $request = $this->post('project', $attributes);
        $request->assertStatus(302);

        $this->assertCount(2, Project::first()->tasks);
    }
}
