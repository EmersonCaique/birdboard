<?php

namespace Tests\Unit;

use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_completed()
    {
        $task = factory('App\Task')->create();
        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->completed);
    }
}
