<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use App\Task;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();
        $orignalTitle = $project->title;

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);

        tap($project->activity->last(), function ($activity) use ($orignalTitle) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /**
     * @test
     */
    public function update_a_project()
    {
        $project = ProjectFactory::create();
        $orignalTitle = $project->title;

        $project->update(['title' => 'change']);

        tap($project->activity->last(), function ($activity) use ($orignalTitle) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => ['title' => $orignalTitle],
                'after' => ['title' => 'change'],
            ];

            $this->assertEquals($expected, $activity->changes);
        });

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function creating_new_task()
    {
        $project = ProjectFactory::create();
        $project->addTask('Task');

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Task', $activity->subject->body);
        });

        $this->assertCount(2, $project->activity);
    }

    /**
     * @test
     */
    public function completing_new_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner)
            ->put(route('project.task.update', ['project' => $project->id, 'task' => $project->tasks->first()->id]), [
                'body' => 'test',
                'completed' => true,
            ]);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertCount(3, $project->activity);
    }

    /**
     * @test
     */
    public function imcompleting_new_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner)
            ->put(route('project.task.update', ['project' => $project->id, 'task' => $project->tasks->first()->id]), [
                'body' => 'test',
                'completed' => true,
            ]);

        $this->assertCount(3, $project->activity);

        $this
            ->actingAs($project->owner)
            ->put(route('project.task.update', ['project' => $project->id, 'task' => $project->tasks->first()->id]), [
                'body' => 'test',
                'completed' => false,
            ]);

        $this->assertCount(4, $project->fresh()->activity);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks->first()->delete();
        $this->assertCount(3, $project->activity);
    }
}
