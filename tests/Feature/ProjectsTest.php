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
    public function a_user_can_create_a_project(){
        $this->actingAs(factory('App\User')->create());

        $project = ['title' => $this->faker->word, 'description' => $this->faker->sentence];
        $request =  $this->post('project', $project);
        $request->assertStatus(302);

        $this->assertDatabaseHas('projects', $project);
    }

    /**
     * @test
     */
    public function a_user_can_view_a_project(){
        $project = factory('App\Project')->create();
        $response = $this->get(route('project.show', ['project' => $project->id ]));
        $response->assertSee('title');

    }

    /**
     * @test
     */
    public function a_project_requires_a_title(){
        $project = factory('App\Project')->raw(['title' => '']);
        $request =  $this->post('project', $project);
        $request->assertSessionHasErrors('title');

    }

    /**
     * @test
     */
    public function a_project_requires_a_description(){
        $project = factory('App\Project')->raw(['description' => '']);
        $request =  $this->post('project', $project);
        $request->assertSessionHasErrors('description');

    }
}
