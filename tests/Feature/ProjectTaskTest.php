<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_project_can_have_tasks(){
        // $this->withoutExceptionHandling();
        $this->auth();
        $project = factory('App\Project')->raw();
        $project = auth()->user()->projects()->create($project);

        $response = $this->post(route('project.task.store', ['project' => $project->id ]), ['body' =>  'Test Task' ]  );
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'body' => 'Test Task'
        ]);


        $this->get(route('project.show', ['project' => $project->id ]))
            ->assertSee('Test Task');
    }

    /**
     * @test
     */
    public function a_task_require_a_body(){

        $this->auth();

        $project = factory('App\Project')->raw();
        $project = auth()->user()->projects()->create($project);
        $task = factory('App\Task')->raw(['body' => null]);

        $response = $this->post(route('project.task.store', ['project' => $project->id ]), $task);
        $response->assertSessionHasErrors('body');
    }
}
