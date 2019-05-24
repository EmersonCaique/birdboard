<?php

namespace Tests\Unit;

use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @test
     */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }

    /**
     * @test
     */
    public function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $project->addTask('Body');

        $this->assertCount(1, $project->tasks);
        $this->assertDatabaseHas('tasks', [
            'body' => 'Body',
        ]);
    }
}
