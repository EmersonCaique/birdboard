<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project_record_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);
    }

    /**
     * @test
     */
    public function update_a_project_record_activity()
    {
        $project = ProjectFactory::create();
        $project->update([
            'title' => 'change',
        ]);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function creating_new_task_record_project_activity()
    {
        $project = ProjectFactory::create();
        $project->addTask('Task');

        $this->assertCount(2, $project->activity);
    }

    /**
     * @test
     */
    public function completing_new_task_record_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner)
            ->put(route('project.task.update', ['project' => $project->id, 'task' => $project->tasks->first()->id]),
            ['body' => 'test', 'completed' => true]);

        $this->assertCount(4, $project->activity);
    }
}
