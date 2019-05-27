<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

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

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = factory('App\Project')->create();
        $project->invite($user = factory('App\User')->create());

        $this->assertTrue($project->members->contains($user));
    }
}
