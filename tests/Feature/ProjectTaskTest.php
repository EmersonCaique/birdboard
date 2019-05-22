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
    public function a_task_can_be_updated(){
        $this->auth();
        $project = factory('App\Project')->raw();
        $project = auth()->user()->projects()->create($project);

        $task = $project->addTask('update test');

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'change test',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'change test',
            'completed' => true,
        ]);

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

    /**
     * @test
     */
     public function only_the_owner_of_project_may_add_tasks(){
        $this->auth();

        $project = factory('App\Project')->create();
        $task = factory('App\Task')->raw(['body' => 'Test body']);

        $response = $this->post(route('project.task.store', ['project' => $project->id ]), $task);
        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task);


     }

    /**
     * @test
     */
    public function only_the_owner_of_project_may_update_a_task(){
        $this->auth();

        $this->auth();
        $project = factory('App\Project')->create();
        $task = $project->addTask('update test');

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'change test',
            'completed' => true,
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'change test',
            'completed' => true,
        ]);


     }


}
