<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->auth();
        $project = ProjectFactory::ownedUser($user)->create();
        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
