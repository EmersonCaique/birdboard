<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();

        $response = $this->post(route('project.task.store', ['project' => $project->id]), ['body' => 'Test Task']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'body' => 'Test Task',
        ]);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertSee('Test Task');
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();
        $task = $project->addTask('update test');

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'change test',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'change test',
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();
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
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();
        $task = $project->addTask('update test');

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'change test',
            'completed' => true,
        ]);

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $task->id]), [
            'body' => 'change test',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'change test',
            'completed' => false,
        ]);
    }

    /**
     * @test
     */
    public function a_task_require_a_body()
    {
        $project = ProjectFactory::ownedUser($this->auth())->create();
        $task = factory('App\Task')->raw(['body' => null]);

        $response = $this->post(route('project.task.store', ['project' => $project->id]), $task);
        $response->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function only_the_owner_of_project_may_add_tasks()
    {
        $this->auth();

        $project = ProjectFactory::withTasks(1)->create();

        $response = $this->post(route('project.task.store', ['project' => $project->id]), ['body' => 'add task']);
        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'add task']);
    }

    /**
     * @test
     */
    public function only_the_owner_of_project_may_update_a_task()
    {
        $this->auth();
        $project = ProjectFactory::withTasks(1)->create();

        $this->put(route('project.task.update', ['project' => $project->id, 'task' => $project->tasks->first->toArray()]), [
            'body' => 'change test',
            'completed' => true,
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'change test',
            'completed' => true,
        ]);
    }
}
