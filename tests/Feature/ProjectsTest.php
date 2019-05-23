<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $project = factory('App\Project')->create();
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
        $this->withoutExceptionHandling();

        $project = ['title' => $this->faker->word, 'description' => $this->faker->sentence, 'notes' => $this->faker->sentence];
        $request = $this->post('project', $project);
        $request->assertStatus(302);

        $this->assertDatabaseHas('projects', $project);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {
        $this->auth();
        // $this->withoutExceptionHandling();

        $projectEdited = factory('App\Project')->make();
        $project = auth()->user()->projects()->save(factory('App\Project')->make());

        $request = $this->put(route('project.update', ['project' => $project->id]), ['notes' => 'note updated']);
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
}
