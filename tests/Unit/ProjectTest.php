<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    /**
     * @test
     */
    public function it_belongs_to_an_owner(){
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);

    }
}
